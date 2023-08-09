<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| EMIS Routes
|--------------------------------------------------------------------------
*/
//Patient Facing API
Route::get('/emis/pfs/patientRecord/{AccessIdentityGuid}/{NationalPracticeCode}', [\App\Http\Controllers\EmisPfsController::class, 'patientRecord']);
Route::get('/emis/pfs/patientAppointments/{AccessIdentityGuid}/{NationalPracticeCode}', [\App\Http\Controllers\EmisPfsController::class, 'patientAppointments']);


/*
|--------------------------------------------------------------------------
| Personal Demographic Service API (PDS)
|--------------------------------------------------------------------------
*/
//Patient Facing API
Route::get('/pds/', [\App\Http\Controllers\PdsController::class, 'patient']);


