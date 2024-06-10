<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/auth/login', [AuthController::class, 'login']);
Route::post('v1/auth/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('v1/auth/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('v1/forms', [FormController::class, 'create']);
Route::middleware('auth:sanctum')->get('v1/forms', [FormController::class, 'getAllForms']);
Route::middleware('auth:sanctum')->get('v1/forms/{slug}', [FormController::class, 'getFormDetail']);
Route::middleware('auth:sanctum')->post('v1/forms/{slug}/questions', [QuestionController::class, 'addQuestion']);
Route::middleware('auth:sanctum')->delete('v1/forms/{slug}/questions/{question_id}', [QuestionController::class, 'removeQuestion']);
Route::middleware('auth:sanctum')->post('v1/forms/{slug}/responses', [ResponseController::class, 'submitResponse']);
Route::middleware('auth:sanctum')->get('v1/forms/{slug}/responses', [ResponseController::class, 'getResponses']);
