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

use Illuminate\Support\Facades\{
  Hash,
  Validator,
  Auth
};

use App\Services\{
  AuthService,
  ProfileService,
  PhoneValidationService,
};

use App\Http\Requests\AccessRestore\{
  RestorePasswordByPhoneRequest,
};

use App\Models\{
  User,
  Role,
  SmsCode,
};

class AccessRestoreController extends Controller
{
  /**
   * restore user password
   * @param RestorePasswordByPhoneRequest $request
   * @return JsonResponse
   */
  public function restorePasswordByPhone(RestorePasswordByPhoneRequest $request): JsonResponse
  {
    $input = $request->validated();
    $sms_code = SmsCode::query()
      ->where('phone', $input['phone'])
      ->where('prefix', $input['prefix'])
      ->whereNotNull('validated_at')
      ->first();

    if ($sms_code) {
      try {
        $user = AuthService::findUserByPhone($input['prefix'], $input['phone']);
        $user = AuthService::changePassword($user, $input['password']);

        // Delete all user's validation codes
        SmsCode::query()
          ->where('phone',  $input['phone'])
          ->where('prefix', $input['prefix'])
          ->delete();

        // Create token
        $token = AuthService::createToken($request, $user);

        // Get profile with relations
        $user = ProfileService::get($user);

        return response()->json([
          'token' => $token,
          'user'  => $user,
        ]);
      }
      catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY );
      }
    }
    return response()->json([], Response::HTTP_NOT_FOUND);
  }
}
