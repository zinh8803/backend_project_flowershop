<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VNPayController;
use App\Http\Resources\UserResource;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('/api/documentation', [SwaggerController::class, 'api'])->name('swagger.docs');

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

//Route::middleware(['auth:sanctum','check.api.token:Employee'])->get('user/profile', [LoginController::class, 'profile']);
Route::get('user/profile', [LoginController::class, 'profile']);

// Route::get('/user/profile', [LoginController::class, 'profile']);



Route::middleware(['auth:sanctum', 'check.api.token:user'])->group(function () {
 //   Route::get('/user/profile', [LoginController::class, 'profile']);
Route::put('/users/UpdateProfile', [UserController::class, 'update']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/users/update-avatar', [UserController::class, 'updateAvatar']);

});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);


Route::get('/products/search', [ProductController::class, 'searchProducts']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/discount-product', [ProductController::class, 'getallproductdiscount']);
Route::get('/products/get8products', [ProductController::class, 'get8product']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/category/{category_id}', [ProductController::class, 'showByCategory']);

Route::get('/discounts', [DiscountController::class, 'index']);

Route::get('/discounts/code={code}', [DiscountController::class, 'show']);


Route::get('product-discounts', [ProductDiscountController::class, 'index']);

Route::delete('product-discounts/{id}', [ProductDiscountController::class, 'destroy']);

Route::get('/Order', [OrderController::class, 'index']);
Route::get('/Order/{id}', [OrderController::class, 'show']);
Route::post('/Order', [OrderController::class, 'store']);
Route::put('/Order/{id}/status', [OrderController::class, 'updateStatus']);
Route::delete('/Order/{id}', [OrderController::class, 'destroy']);









Route::post('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::middleware(['auth:sanctum','check.api.token:Employee'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);



    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);


    Route::post('/discounts', [DiscountController::class, 'store']);
    Route::post('/discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('/discounts/{id}', [DiscountController::class, 'destroy']);


    Route::post('product-discounts', [ProductDiscountController::class, 'store']);
    Route::post('product-discounts/{id}', [ProductDiscountController::class, 'update']);


    Route::post('/employees/register', [EmployeeController::class, 'register']);    

    Route::get('/employees', [EmployeeController::class, 'index']);



    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);
    Route::get('/employees/schedules/{employee_id}', [ScheduleController::class, 'show']);
    Route::post('/schedules/{id}', [ScheduleController::class, 'update']);


    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/positions/{id}', [PositionController::class, 'show']);
    Route::post('/positions', [PositionController::class, 'store']);
    Route::put('/positions/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);

});

Route::put('/employees/{id}', [EmployeeController::class, 'update']);

Route::get('/invoices', [InvoiceController::class, 'index']);
Route::get('/invoices/{id}', [InvoiceController::class, 'show']);   
Route::post('/invoices', [InvoiceController::class, 'store']);
Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);

Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);

Route::post('/payment',[VNPayController::class, 'createPayment']); 
Route::get('/vnpay_return', [VNPayController::class, 'vnpayReturn']); 