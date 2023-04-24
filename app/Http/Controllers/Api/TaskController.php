<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\{
  Request,
  JsonResponse,
};

use \App\Http\Requests\Task\{
  TaskCreateRequest,
};

use App\Models\{
  User,
  Task,
  Category,
  Position,
  Purchase,
  Setting,
};

use App\Services\{
  RigService,
};

class TaskController extends Controller
{
  /**
   * List
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    $per_page  = 25;
    $only_owner = $request->get('only_owner');

    $task_list = Task::query();

    if ($only_owner === 'true') {
      $user = $request->user();
      if ($user) {
        $task_list = $task_list->where('real_user_id', $user->increment);
      }
    }
    $task_list = $task_list->orderByDesc('id')
      ->paginate($per_page);

    return response()->json([
      'tasks' => $task_list,
    ]);
  }

  /**
   * Create
   * @param  \App\Http\Requests\Task\TaskCreateRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(TaskCreateRequest $request): JsonResponse
  {
    $input = $request->validated();
    // $user  = $request->user();
    $user  = User::find(1095);

    $position_id = $input['position_id'];
    $hash        = $input['hash'];

    // Position check
    $position = Position::with('category')->where('position_id', $position_id)->first();
    if (!$position) {
      return response()->json(['position' => 'Position not found'], Response::HTTP_NOT_FOUND);
    }

    // Balance check
    $price = $position->position_price;
    if ($price > 0 && $user->balance < $price) {
      return response()->json(['balance' => 'Not enough funds'], Response::HTTP_PAYMENT_REQUIRED);
    }

    // Step 1 - prepare
    $hash_type_id = $position->category->hash_type_id;
    $encoded_hash = base64_encode($hash);

    # Step 2 - now we got hashListId
    $response = RigService::createHashlist($hash_type_id, $encoded_hash);
    if ($response->response !== "OK") {
      return RigService::errorJsonResponse("createHashlist", $response);
    }

    $hashlist_id = $response->hashlistId;
    $supertaskId = $position->supertask_id;

    # Run supertask
    $response2 = RigService::runSupertask($hashlist_id, $supertaskId);
    if ($response2->response !== "OK") {
      return RigService::errorJsonResponse("runSupertask", $response2);
    }

    # Get task list
    $response3 = RigService::listTasks();
    if ($response3->response !== "OK") {
      return RigService::errorJsonResponse("listTasks", $response3);
    }

    // Searching task
    $task = collect($response3->tasks)->first(function ($item) use ($hashlist_id) {
      return isset($item->hashlistId) ? $item->hashlistId === $hashlist_id : false;
    });

    if ($task) {
      $settingPriority = Setting::priority()->first();
      $newPriority     = $settingPriority->value - 1;

      # Set supertask priority
      $response4 = RigService::setSupertaskPriority($task->supertaskId, $newPriority);
      if ($response4->response !== "OK") {
        return RigService::errorJsonResponse("setSupertaskPriority", $response4);
      }

      # Decrease task priority from settings
      $settingPriority->update(["value" => $newPriority]);

      # Create purchase
      $payload_purchase = Purchase::createPayload($user, $price, $hashlist_id);
      Purchase::create($payload_purchase);

      # Create task
      $task_id      = $task->supertaskId;
      $payload_task = Task::createPayload($user, $position, $hashlist_id, $task_id, $newPriority, $hash);
      $new_task     = Task::create($payload_task);

      # Withdraw payment
      $new_balance  = $user->balance - $price;
      $user->update(['balance' => $new_balance]);

      return response()->json(['task' => $new_task]);
    }
    else {
      return response()->json(['reason' => 'Task was not found'], Response::HTTP_SERVICE_UNAVAILABLE);
    }
  }
}
