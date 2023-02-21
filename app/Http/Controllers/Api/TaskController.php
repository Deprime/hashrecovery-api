<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\{
  Request,
  JsonResponse,
};

use App\Models\{
  Task,
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
}
