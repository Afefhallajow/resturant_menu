<?php

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
Route::get('/category',[\App\Http\Controllers\MyController\CategoriesController::class,'index'] );
Route::get('/category/{id}',[\App\Http\Controllers\MyController\CategoriesController::class,'show'] );
Route::post('/category',[\App\Http\Controllers\MyController\CategoriesController::class,'store'] );
Route::put('/category/{id}',[\App\Http\Controllers\MyController\CategoriesController::class,'update'] );
Route::delete('/category/{id}',[\App\Http\Controllers\MyController\CategoriesController::class,'destroy'] );

Route::resource("subcategory",\App\Http\Controllers\MyController\SubcategoriesController::class);
Route::resource("item",\App\Http\Controllers\MyController\ItemController::class);
Route::resource("menu",\App\Http\Controllers\MyController\MenuController::class);
