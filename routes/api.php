<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\{
  SigninController,
  SignupController,
  VerificationController,
  AccessRestoreController,
};

use App\Http\Controllers\Api\{
  ProfileController,
  TaskController,
  RigController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function() {
  Route::prefix('v1')->group(function () {
    // Authorization
    Route::prefix('auth')->group(function () {
      Route::post('signup',           [SignupController::class, 'signup']);
      Route::post('signin',           [SigninController::class, 'signin']);
      Route::post('signin-telegram',  [SigninController::class, 'signinTelegram']);
      Route::delete('logout',         [SigninController::class, 'logout']);
      Route::post('restore-password', [AccessRestoreController::class, 'restorePasswordByPhone']);
    });

    Route::prefix('rig')->group(function () {
      Route::get('/connection',         [RigController::class, 'connection']);
      Route::get('/access',             [RigController::class, 'access']);
      Route::get('/agents',             [RigController::class, 'listAgents']);
      Route::get('/agents/{agent_id}',  [RigController::class, 'get'])->whereNumber('agent_id');
    });

    // Application
    Route::prefix('app')->group(function() {
      Route::prefix('task')->group(function() {
        Route::get('/',   [TaskController::class, 'list']);
      });

      Route::group(['middleware' => ['auth:sanctum']], function () {
        // Profile
        Route::prefix('profile')->group(function() {
          Route::get('/',                  [ProfileController::class, 'get']);
          Route::put('/',                  [ProfileController::class, 'update']);
          Route::put('/change-password',   [ProfileController::class, 'changePassword']);
          Route::get('/sessions',          [ProfileController::class, 'getSessions']);
          Route::post('/telegram-connect', [ProfileController::class, 'telegramConnect']);
        });
      });
    });
  });
});

