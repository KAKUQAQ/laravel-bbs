<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Lab404\Impersonate\Controllers\ImpersonateController;
use Mews\Captcha\Captcha;
use Mews\Captcha\CaptchaController;

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

Route::get('/', [PagesController::class,'root'])->name('root');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::resource('users', UsersController::class)->only(['show', 'edit', 'update']);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', [TopicsController::class, 'uploadImage'])->name('topics.upload_image');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy', 'index']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('/impersonate/{id}', [UsersController::class, 'impersonateUser'])->name('impersonate');

Route::get('/stop-impersonating', [UsersController::class, 'stopImpersonating'])->name('stopImpersonating');
