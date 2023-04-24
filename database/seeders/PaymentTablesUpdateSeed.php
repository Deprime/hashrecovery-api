<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{
  Refill,
  BtcPayment,
  User,
};

class PaymentTablesUpdateSeed extends Seeder
{
  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    // Crypto
    $payments = BtcPayment::get();
    foreach ($payments as $key => $payment) {
      $user = User::where('user_id', $payment->userid)->first();
      if ($user) {
        $payment->update(['real_user_id' => $user->increment]);
      }
    }

    // Fiat
    $payments = Refill::get();
    foreach ($payments as $key => $payment) {
      $user = User::where('user_id', $payment->user_id)->first();
      if ($user) {
        $payment->update(['real_user_id' => $user->increment]);
      }
    }
  }
}
