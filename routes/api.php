<?php

use App\Http\Controllers\CookingForHires\CookingForHireController;
use App\Http\Controllers\CookingForHires\CookingForHireOwnController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\SetPasswordController;
use App\Http\Controllers\Params\ParamController;
use App\Http\Controllers\params\CorrectionController;
use App\Http\Controllers\params\FruitController;
use App\Http\Controllers\SoldProducts\SoldProductController;
use App\Http\Controllers\Statistics\CookingForHiresOwnStatisticsController;
use App\Http\Controllers\Statistics\CookingForHiresStatisticsController;
use App\Http\Controllers\Statistics\SoldProductsStatisticsController;
use App\Http\Controllers\Storages\MashStroageController;
use App\Http\Controllers\storages\PalinkaStorageController;
use App\Http\Controllers\Storages\StorageController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Login
Route::delete('/login', [LoginController::class, 'login']);
Route::put('/setpassword/{id}', [SetPasswordController::class, 'update']);

//Users
Route::get('/user', [UserController::class, 'list']);
Route::post('/user', [UserController::class, 'create']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'delete']);
Route::get('/user/export', [UserController::class, 'export']);

//Params
Route::get('/params', [ParamController::class, 'list']);
Route::put('/params/{id}', [ParamController::class, 'update']);
Route::get('/correction', [CorrectionController::class, 'list']);
Route::get('/fruit', [FruitController::class, 'list']);
Route::post('/fruit', [FruitController::class, 'create']);
Route::delete('/fruit/{id}', [FruitController::class, 'delete']);

//Storages
Route::get('/storage', [StorageController::class, 'list']);
Route::put('/storage/{id}', [StorageController::class, 'update']);
Route::get('/palinkastorage', [PalinkaStorageController::class, 'list']);
Route::post('/palinkastorage', [PalinkaStorageController::class, 'create']);
Route::delete('/palinkastorage/{id}', [PalinkaStorageController::class, 'delete']);
Route::get('/mashstorage', [MashStroageController::class, 'list']);
Route::post('/mashstorage', [MashStroageController::class, 'create']);
Route::delete('/mashstorage/{id}', [MashStroageController::class, 'delete']);

//CookingForHires
Route::get('/cookingforhire', [CookingForHireController::class, 'list']);
Route::get('/cookingforhireown', [CookingForHireOwnController::class, 'list']);
Route::post('/cookingforhire', [CookingForHireController::class, 'create']);
Route::delete('/cookingforhire/{id}', [CookingForHireController::class, 'delete']);

//Statistics
Route::get('/cookingforhirestatistics', [CookingForHiresStatisticsController::class, 'list']);
Route::get('/cookingforhireownstatistics', [CookingForHiresOwnStatisticsController::class, 'list']);
Route::get('/soldproductstatistics', [SoldProductsStatisticsController::class, 'list']);

//SoldProduct
Route::get('/soldproduct', [SoldProductController::class, 'list']);
Route::post('/soldproduct', [SoldProductController::class, 'create']);
Route::delete('/soldproduct/{id}', [SoldProductController::class, 'delete']);



// Route::middleware('auth:api')->group(function () {
//     Route::resource('users', [UserController::class]);
//     Route::resource('params', [ParamController::class]);
//     Route::resource('corrections', [CorrectionController::class]);
//     Route::resource('fruits', [FruitController::class]);
//     Route::resource('storages', [StorageController::class]);
//     Route::resource('palinkastorages', [PalinkaStorageController::class]);
//     Route::resource('mashstorages', [MashStroageController::class]);
//     Route::resource('cookingforhires', [CookingForHireController::class]);
//     Route::resource('cookingforhiresown', [CookingForHireOwnController::class]);
//     Route::resource('cookingforhirestatistics', [CookingForHiresStatisticsController::class]);
//     Route::resource('soldproductstatistics', [SoldProductsStatisticsController::class]);
//     Route::resource('soldproducts', [SoldProductController::class]);
// });
