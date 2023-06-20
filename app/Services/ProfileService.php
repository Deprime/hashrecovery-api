<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Http\Requests\Signin\{
  SigninTelegramRequest,
};
use \App\Requests\Profile\{
  ProfileUpdateRequest,
  TelegramConnectRequest,
};

class ProfileService {

  protected const RELATIONS = [/*'company', 'realtor_accesses', 'contacts'*/];

  /**
   * Update current user profile
   *
   * @param ProfileUpdateRequest $request
   * @param User $user
   * @return User
   */
  public function update(ProfileUpdateRequest $request): User
  {
    $input = $request->validated();
    $user  = $request->user();
    $user->update($input);
    return $user;
  }


  /**
   * Create user by phone
   *
   * @param User $user
   * @param string $password
   * @return User
   */
  public static function changePassword(User $user, $password): User
  {
    $user->update(['password' => Hash::make($password)]);
    return $user;
  }

  /**
   * Get user profile with relations
   *
   * @param User $user
   * @return User
   */
  public static function get(User $user): User
  {
    // $user->load(static::RELATIONS);
    return $user;
  }

  /**
   * Get relations
   *
   * @param User $user
   * @return Collection
   */
  public static function getReferrals(User $user): Collection
  {
    $user->load('referrals');
    return $user->referrals;
  }

  /**
   * Update telegram data
   *
   * @param SigninTelegramRequest $request
   * @param User $user
   * @return Collection
   */
  public static function updateTelegramData(SigninTelegramRequest $request, User $user): User
  {
    $input   = $request->validated();
    $data = [
      'user_login' => $input['username'],
      'user_name'  => $input['first_name'],
      'avatar'     => $input['avatar'],
    ];

    if (!$user->login) {
      // Create dummy login
      $data['login'] = 'user' . $input['telegram_id'];
      if ($input['username'] && strlen($input['username']) > 0) {
        // Login must be unique, so need to check it
        $sameLoginUser = User::where('login', $input['username'])->first();
        if (!$sameLoginUser) {
          // Now we can set login same as TG username
          $data['login'] = $input['username'];
        }
      }
    }

    $user->update($data);
    return $user;
  }

  /**
   * Connect telegram data
   *
   * @param Request $request
   * @param User $user
   * @return Collection
   */
  public static function connectTelegramData(Request $request, User $user): User
  {
    $input   = $request->validated();
    $tg_data = [
      'user_id'    => $input['telegram_id'],
      'user_login' => $input['username'],
      'user_name'  => $input['first_name'],
      'avatar'     => $input['avatar'],
    ];
    $user->update($tg_data);
    return $user;
  }
}
