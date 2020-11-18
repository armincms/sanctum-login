<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Armincms\SanctumLogin\Http\Controllers\{
	SimpleLoginController, MobileLoginController, TwoFactorLoginController, VerificationController
};

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/


Route::post('simple', [
	'uses' 	=> SimpleLoginController::class,
	'as' 	=> 'login.simple',
]);
Route::post('mobile', [
	'uses' 	=> MobileLoginController::class,
	'as' 	=> 'login.mobile',
]);
Route::post('{hash}/verify', [
	'uses' 	=> VerificationController::class,
	'as' 	=> 'login.verification',
]);
Route::post('two-factor', [
	'uses' 	=> TwoFactorLoginController::class,
	'as' 	=> 'login.two-factor',
]);