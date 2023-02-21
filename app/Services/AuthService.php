<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Str;

class AuthService {

  /**
   * Create user
   * @param string $login
   * @param string $password
   * @return User
   */
  public static function createUserByLogin($login, $password): User
  {
    $input = [
      'login'      => $login,
      'password'   => Hash::make($password),
      'balance'    => 0,
      'all_refill' => 0,
      'reg_date'   => date("Y-m-d H:i:s"),
      'lang'       => app()->getLocale(),
    ];
    return User::create($input);
  }

  /**
   * Create sanctum token
   * @param User $user
   * @return string
   */
  public static function createToken(Request $request, User $user): string
  {
    if ($user->currentAccessToken()) {
      $user->currentAccessToken()->delete();
    }
    $token_creator = $request->login || $user->user_id;
    return $user->createToken($token_creator)->plainTextToken;
  }

  /**
   * Revoke current access token
   * @param User $user
   * @return boolean
   */
  public static function revokeToken(User $user): bool
  {
    if ($user->currentAccessToken()) {
      $user->currentAccessToken()->delete();
      return true;
    }
    return false;
  }

  /**
   * Find user by phone
   * @param string $prefix
   * @param string $phone
   * @return User $user | null
   */
  public static function findUserByPhone(string $prefix, string $phone) {
    $user = User::query()
      ->where('prefix', $prefix)
      ->where('phone', $phone)
      ->first();
    return $user;
  }

  /**
   * Change password
   * @param User $user
   * @param string $password
   * @return User $user | null
   */
  public static function changePassword(User $user, string $password) {
    $input = ['password' => Hash::make($password)];
    $user->update($input);
    return $user;
  }
}
