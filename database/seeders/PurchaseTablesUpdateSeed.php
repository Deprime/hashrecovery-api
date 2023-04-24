<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{
  Purchase,
  User,
};

class PurchaseTablesUpdateSeed extends Seeder
{
  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    $purchases = Purchase::get();
    foreach ($purchases as $key => $purchase) {
      $user = User::where('user_id', $purchase->user_id)->first();
      if ($user) {
        $purchase->update(['real_user_id' => $user->increment]);
      }
    }
  }
}
