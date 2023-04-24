<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{
  Task,
  User,
};

class TasksTableUpdateSeed extends Seeder
{
  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    $tasks = Task::get();
    foreach ($tasks as $key => $task) {
      $user = User::where('user_id', $task->userid)->first();
      if ($user) {
        $task->update(['real_user_id' => $user->increment]);
      }
    }
  }
}
