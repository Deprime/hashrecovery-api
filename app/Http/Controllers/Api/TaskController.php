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
    $task_list = Task::query()
      // ->with(['user'])
      ->orderByDesc('id')
      ->paginate($per_page);

    return response()->json($task_list);
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

    // Position check
    $position = Position::with('category')->where('position_id', $input['position_id'])->first();
    if (!$position) {
      return response()->json(['position' => 'Position not found'], Response::HTTP_NOT_FOUND);
    }

    // Balance check
    $price = $position->position_price;
    if ($price > 0 && $user->balance < $price) {
      return response()->json(['balance' => 'Not enough funds'], Response::HTTP_PAYMENT_REQUIRED);
    }

    $hash_type_id = $position->category->hash_type_id;
    $encoded_hash = base64_encode($input['hash']);
    // return response()->json([$encoded_hash, $hash_type_id]);

    # Step 2 - now we got hashListId

    $response    = RigService::createHashlist($hash_type_id, $encoded_hash);
    $hashlistId  = $response->hashlistId;
    $supertaskId = $position->supertask_id;

    $response2 = RigService::runSupertask($hashlistId, $supertaskId);

    $task_list = RigService::listTasks();
    return response()->json([
      $response2,
    ]);

    // RigService::setSupertaskPriority($hash_type_id, $encoded_hash);

    // # Decrease task priority from settings
    // $setting = Setting::first();
    // $setting->update([
    //   "taskpriority" => $setting->taskpriority - 1,
    // ]);

    // Task::create()

    # Withdraw payment if price > 0
    // if ($price > 0) {
    //   $user->update([
    //     'balance' =>  $user->balance - $price,
    //   ]);

    //   Purchase::create();
    // }

    return response()->json([$input, $response]);
  }
}
