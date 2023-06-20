<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\SmsAero;

use Illuminate\Support\Facades\{
  Hash,
  Validator,
  Auth
};

use App\Services\{
  AuthService,
  ProfileService,
};

use App\Http\Requests\Signin\{
  SigninRequest,
  SigninTelegramRequest,
};

use App\Models\{
  User,
  SmsCode,
};

class SigninController extends Controller
{
  /**
   * Signin
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function signin(SigninRequest $request): JsonResponse
  {
    $input = $request->validated();
    if (!Auth::attempt($input)) {
      return response()->json(['error' => 'The provided credentials are incorrect'], Response::HTTP_UNAUTHORIZED);
    }

    /** @var User $user */
    $user  = $request->user();
    $token = AuthService::createToken($request, $user);

    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json([
      'token' => $token,
      'user' => $user,
    ]);
  }

  /**
   * Signin telegram
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function signinTelegram(SigninTelegramRequest $request): JsonResponse
  {
    $input = $request->validated();
    /** @var User $user */
    $user = User::where('user_id', $input['telegram_id'])->first();
    if (!$user) {
      return response()->json(['error' => 'The provided credentials are incorrect'], Response::HTTP_UNAUTHORIZED);
    }



    $token = AuthService::createToken($request, $user);
    $user  = ProfileService::updateTelegramData($request, $user);
    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json([
      'token' => $token,
      'user'  => $user,
    ]);
  }

  /**
   * Logout
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout(Request $request): JsonResponse
  {
    $user = $request->user();
    if ($user) {
      AuthService::revokeToken($user);
    }
    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
