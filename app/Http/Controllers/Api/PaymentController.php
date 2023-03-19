<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Models\{
  Position,
  // Category,
  User,
  Refill,
  BtcPayment,
};

use \App\Http\Requests\Payment\{
  QiwiPaymentRequest,
  CryptoPaymentRequest,
};

class PaymentController extends Controller
{
  /**
   * Payment list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function list(Request $request)
  {
    $user   = $request->user();
    $fiat   = Refill::where('user_id', $user->user_id)->get();
    $crypto = BtcPayment::where('userid', $user->increment)->get();
    return response()->json(['fiat' => $fiat, 'crypto' => $crypto], Response::HTTP_OK);
  }

  /**
   * Payment info
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function get(Request $request, int $payment_id)
  {
    $positions = Position::with(['category'])->get();
    return response()->json($positions, Response::HTTP_OK);
  }

  /**
   * Create qiwi payment
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createFiat(QiwiPaymentRequest $request)
  {
    $input = $request->validated();
    $user  = $request->user();
    $amount = $input['amount'] * config('services.currency.usd2rub');

    $billPayments = new \Qiwi\Api\BillPayments(config('services.qiwi.secret-key'));
    $billId = rand(100000000000, 999999999999);
    $lifetime = $billPayments->getLifetimeByDay(0.0208);
    // $increment = 187123519;
    // dd($billPayments);

    $fields = [
      'amount'   => $amount,
      'currency' => 'RUB',
      'comment'  => 'payment via LK for user ' . $user->increment,
      'account'  => $user->increment,
      // 'comment'  => 'payment via LK for user ' . $increment,
      // 'account'  => $increment,
      'expirationDateTime' => $lifetime,
    ];

    /** @var \Qiwi\Api\BillPayments $billPayments */
    $response = $billPayments->createBill($billId, $fields);
    // dd($response);

    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Create crypto payment
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createCrypto(CryptoPaymentRequest $request)
  {
    $input = $request->validated();
    $user  = $request->user();
    $amount = $input['amount'] * config('services.currency.usd2rub');

    $payload = [
      "auth_login"  => config('services.crystalpay.login'),
      "auth_secret" => config('services.crystalpay.secret-key'),
      "type"        => "purchase",
      "amount"      => $amount,
      "lifetime"    => date("Y/m/d H:i:s", strtotime("+30 minutes")),
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.crystalpay.io/v2/invoice/create/");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $raw_response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($raw_response);

    if (!$result->error) {
      $payment = BtcPayment::create([
        'userid'    => $user->increment,
        'crystalid' => $result->id,
        'date'      => strtotime(date("Y-m-d H:i:s")),
        'finish'    => false,
        'cost'      => $amount,
      ]);

      $response = [
        "id"  => $result->id,
        "url" => $result->url,
      ];

      return response()->json($response, Response::HTTP_OK);
    }
    else {
      return response()->json(['error' => "Payment gateway errro"], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }
}
