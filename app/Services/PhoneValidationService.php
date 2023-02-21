<?php

namespace App\Services;

use App\Helpers\{
  SmsAero,
  HiCall,
};

use App\Models\{
  User,
  SmsCode,
};

class PhoneValidationService {

  /**
   * Create user
   * @param string $prefix
   * @param string $phone
   * @return string|null
   */
  public static function sendCode(string $prefix, string $phone): string|null
  {
    $number = $prefix . $phone;
    $code = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);

    if (config('app.env') === "production") {
      $response = HiCall::call($number);

      if ($response['status'] === 'error') {
        return null;
      }

      $code = $response['code'];
    }

    $sms_code = SmsCode::create([
      'prefix' => $prefix,
      'phone'  => $phone,
      'code'   => $code,
    ]);

    return $code;
  }

  /**
   * Verify validation code
   * @param string $prefix
   * @param string $phone
   * @param string $code
   * @return SmsCode|null
   */
  public static function verifyCode(string $prefix, string $phone, string $code): SmsCode | null
  {
    $sms_code = SmsCode::query()
      ->where('code', $code)
      ->where('phone', $phone)
      ->where('prefix', $prefix)
      ->first();

    if ($sms_code) {
      $sms_code->update(['validated_at' => date("Y-m-d H:i:s")]);
      return $sms_code;
    }
    return null;
  }
}
