<?php

use App\Http\Controllers\AcceptInviteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyPreferenceController;
use App\Http\Controllers\UserGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome');

Route::group(['middleware' => ['guest']], static function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

    Route::get('invites/accept/{token?}', [AcceptInviteController::class, 'showAcceptInviteForm'])
        ->name('invites.accept');
});

Route::group(['middleware' => ['auth']], static function () {
    Route::group(['prefix' => 'verify-email', 'as' => 'verification.'], static function () {
        Route::get('/', EmailVerificationPromptController::class)->name('notice');
        Route::get('{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verify');
    });

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::put('me', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('me/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::view('me', 'profile.edit')->name('profile.edit');

    Route::group(['middleware' => ['verified']], static function () {
        // Property Preference Routes...
        Route::delete('property-preferences/{property_preference}', [PropertyPreferenceController::class, 'destroy'])
            ->name('property-preferences.destroy');

        // Property Routes...
        Route::group(
            ['as' => 'properties.', 'prefix' => 'properties'],
            static function () {
                Route::post('{property}/dislike', [PropertyController::class, 'dislike'])->name('dislike');
                Route::post('{property}/like', [PropertyController::class, 'like'])->name('like');
                Route::post('{id}/reprocess', [PropertyController::class, 'reprocess'])->name('reprocess');
                Route::get('{id}', [PropertyController::class, 'show'])->name('show');
                Route::delete('{id}', [PropertyController::class, 'destroy'])->name('destroy');
                Route::post('/', [PropertyController::class, 'store'])->name('store');
            }
        );

        // User Group Routes...
        Route::view('user-groups/create', 'user-groups.create')
            ->name('user-groups.create');
        Route::post('user-groups', [UserGroupController::class, 'store'])
            ->name('user-groups.store');
    });
});
