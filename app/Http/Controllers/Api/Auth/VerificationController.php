<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\{
  SmsAero,
  HiCall,
};


use App\Services\{
  PhoneValidationService,
};

use App\Http\Requests\Verification\{
  SendVerificationCodeRequest,
  ValidateVerificationCodeRequest,
};

use App\Models\{
  User,
  SmsCode,
};

class VerificationController extends Controller
{
  /**
   * Send validation code
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendValidationCode(SendVerificationCodeRequest $request): JsonResponse
  {
    $input    = $request->validated();
    $sms_code = PhoneValidationService::sendCode($input['prefix'], $input['phone']);

    if ($sms_code) {
      return response()->json($sms_code, Response::HTTP_OK);
    }
    return response()->json(['error' => 'trottling'], Response::HTTP_TOO_MANY_REQUESTS);
  }

  /**
   * Verify validation code
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function verifyValidationCode(ValidateVerificationCodeRequest $request): JsonResponse
  {
    $input    = $request->validated();
    $sms_code = PhoneValidationService::verifyCode($input['prefix'], $input['phone'], $input['code']);

    if ($sms_code) {
      return response()->json($sms_code);
    }
    return response()->json([], Response::HTTP_NOT_FOUND);
  }
}
