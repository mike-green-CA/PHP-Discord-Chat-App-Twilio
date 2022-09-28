<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordRecoveryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [IndexController::class, 'index'])->name('welcome');
Route::post('/thanks', [IndexController::class, 'thanks'])->name('thanks');

Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::post('/loginAuthorization', [IndexController::class, 'loginAuthorization'])->name('loginAuthorization');

route::get('/forgotPassword', [PasswordRecoveryController::class, 'forgotPassword'])->name('forgotPassword');
route::post('/passwordResetSendCode', [PasswordRecoveryController::class, 'passwordResetSendCode'])->name('passwordResetSendCode');
route::get('/passwordResetSendCode', [PasswordRecoveryController::class, 'passwordResetSendCodeErr'])->name('passwordResetSendCode');
route::post('/passwordResetCodeCheck', [PasswordRecoveryController::class, 'passwordResetCodeCheck'])->name('passwordResetCodeCheck');
route::get('/passwordResetCodeCheck', [PasswordRecoveryController::class, 'passwordResetCodeCheckErr'])->name('passwordResetCodeCheck');
route::post('/passwordReset',[PasswordRecoveryController::class, 'passwordReset'])->name('passwordReset');
route::get('/passwordResetThankYou',[PasswordRecoveryController::class, 'passwordResetThankYou'])->name('passwordResetThankYou');
route::get('/passwordResetToLogin',[PasswordRecoveryController::class, 'sendToLogin'])->name('passwordResetToLogin');

Route::get('/signup', [IndexController::class, 'signup'])->name('signup');
route::get('/confirmphonelanding', [IndexController::class, 'confirmPhoneLandingErr'])->name('confirmPhoneLanding');
route::post('/confirmphonelanding', [IndexController::class, 'confirmPhoneLanding'])->name('confirmPhoneLanding');
route::get('/phoneConfirm', [IndexController::class, 'phoneConfirm'])->name('phoneConfirm');

Route::get('/about', [IndexController::class, 'about'])->name('about');

Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard')->middleware('auth:profile');

Route::get('/secret-chat', [ProfileController::class, 'secretChat'])->name('secretChat')->middleware('auth:profile');

Route::get('/discord', [LoginController::class, 'discord'])->name('discord');
Route::get('/authorize', [LoginController::class, 'callback'])->name('callback');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:profile');

Route::get('/me', [ProfileController::class, 'me'])->name('profiles-me')->middleware('auth:profile');
Route::get('/profiles/all', [ProfileController::class, 'all'])->name('profiles-all')->middleware('auth:profile');;

Route::post('/wishes', [PostController::class, 'new'])->name('wishes-new');
Route::get('/wishes/user', [PostController::class, 'wishes'])->name('wishes-all');


