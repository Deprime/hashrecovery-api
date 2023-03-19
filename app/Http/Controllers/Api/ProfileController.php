<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\SmsAero;

use \App\Http\Requests\Profile\{
  ProfileUpdateRequest,
  ProfileChangePasswordRequest,
  ProfileContactsRequest,
  TelegramConnectRequest,
};

use App\Services\{
  ProfileService,
};

use App\Models\{
  User,
  Role,
};

class ProfileController extends Controller
{
  protected const RELATIONS = ['company', 'realtor_accesses', 'contacts'];

  /**
   * Get current user profile
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function get(Request $request): JsonResponse
  {
    $user = $request->user();

    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json(['user' => $user]);
  }

  /**
   * Update current user profile
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(ProfileUpdateRequest $request): JsonResponse
  {
    $user  = $request->user();
    $input = $request->validated();
    $user->update($input);

    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json(['user' => $user]);
  }

  /**
   * Change password
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function changePassword(ProfileChangePasswordRequest $request): JsonResponse
  {
    $input = $request->validated();
    $user  = ProfileService::changePassword($request->user(), $input['password']);

    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json(['user' => $user]);
  }

  /**
   * Get contacts list
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getContacts(Request $request): JsonResponse
  {
    $user = $request->user();
    $contact_list = $user->contacts;
    return response()->json($contact_list);
  }

  /**
   * Update contacts
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateContacts(ProfileContactsRequest $request): JsonResponse
  {
    $user  = $request->user();
    $input = $request->validated();

    // Sync contacts
    $contacts = $input['contacts'];
    $syncable_contacts = [];
    foreach ($contacts as $contact) {
      $syncable_contacts[$contact['id']] = [
        'content' => $contact['content']
      ];
    }
    $user->contacts()->sync($syncable_contacts);

    // Get profile with relations
    $user = ProfileService::get($user);

    return response()->json(['user' => $user]);
  }

  /**
   * Get referrals list
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getReferrals(Request $request): JsonResponse
  {
    $user = $request->user();
    $refferrals_list = ProfileService::getReferrals($user);
    return response()->json($refferrals_list);
  }

  /**
   * Get referral info
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getReferralInfo(Request $request,int $ref_id): JsonResponse
  {
    $user = $request->user();
    $refferral = ProfileService::getReferrals($user)->where('id', '=', $ref_id)->firstOrFail();
    return response()->json([]);
  }

  /**
   * Get session list
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getSessions(Request $request): JsonResponse
  {
    $user = $request->user();
    $tokens = $user->tokens()->get();
    return response()->json($tokens);
  }

  /**
   * Get session list
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function telegramConnect(TelegramConnectRequest $request): JsonResponse
  {
    $user = $request->user();

    if ($user->user_id) {
      return response()->json(['error' => 'The provided credentials are incorrect'], Response::HTTP_UNAUTHORIZED);
    }

    $user = ProfileService::connectTelegramData($request, $user);
    return response()->json(['user' => $user]);
  }
}
