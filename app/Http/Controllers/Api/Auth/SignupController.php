<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

use App\Http\Requests\Signup\{
  SignupRequest,
};

use App\Models\{
  User,
};

class SignupController extends Controller
{
  /**
   * Signup via email
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function signup(SignupRequest $request): JsonResponse
  {
    $input = $request->validated();

    try {
      $user = AuthService::createUserByLogin($input['login'], $input['password']);
    }
    catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY );
    }

    $token = AuthService::createToken($request, $user);
    return response()->json(['token' => $token]);
  }
}
