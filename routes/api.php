<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::group(['middleware' => 'jwt.auth'], function (){
        Route::post('/create/new', [\App\Http\Controllers\BlockController::class, 'create']);
        Route::post('/delete/new/{id?}', [\App\Http\Controllers\BlockController::class, 'destroy']);
        Route::post('/create/teacher', [\App\Http\Controllers\EmployerController::class, 'create']);
        Route::post('/edit/teacher', [\App\Http\Controllers\EmployerController::class, 'edit']);
        Route::post('/delete/teacher/{id?}', [\App\Http\Controllers\EmployerController::class, 'delete']);
        Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'show']);
        Route::get('/comments', [\App\Http\Controllers\CommentController::class, 'show']);
        Route::post('/create/post/{id?}', [\App\Http\Controllers\PostController::class, 'create']);
        Route::post('/edit/post/{id?}', [\App\Http\Controllers\PostController::class, 'edit']);
        Route::post('/delete/post/{id?}', [\App\Http\Controllers\PostController::class, 'destroy']);
        Route::post('/send/message/email', [\App\Http\Controllers\MessageController::class, 'send']);
        Route::post('/change/status/comment/{id?}', [\App\Http\Controllers\CommentController::class, 'change_status']);
        Route::post('/change/table/diagnoses', [\App\Http\Controllers\DiagnoseController::class, 'change']);
        Route::get('/post/{id?}', [\App\Http\Controllers\PostController::class, 'show_id']);
    });
});

Route::get('/diagnoses', [\App\Http\Controllers\DiagnoseController::class, 'show']);
Route::get('/news/desktop/{id?}', [\App\Http\Controllers\ElementController::class, 'show_desktop']);
Route::get('/news/tablet/{id?}', [\App\Http\Controllers\ElementController::class, 'show_tablet']);
Route::get('/news/mobile/{id?}', [\App\Http\Controllers\ElementController::class, 'show_mobile']);
Route::get('/specialization', [\App\Http\Controllers\EmployerController::class, 'get_special']);
Route::get('/teachers', [\App\Http\Controllers\EmployerController::class, 'get_teachers']);
Route::get('/posts/{id?}', [\App\Http\Controllers\PostController::class, 'show']);
Route::get('/comments/post/{id?}', [\App\Http\Controllers\CommentController::class, 'show_user']);

Route::post('/send/message', [\App\Http\Controllers\MessageController::class, 'create']);
Route::post('/send/comment', [\App\Http\Controllers\CommentController::class, 'create']);
