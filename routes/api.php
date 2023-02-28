<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\TagsController;
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

Route::controller(AuthenticationController::class)->group(function() {
    Route::post('authentication/register', 'register');
    Route::post('authentication/login', 'login');
});

Route::apiResources([
    'categories' => CategoriesController::class,
    'posts' => PostsController::class,
    'tags' => TagsController::class,
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
