<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\brandsController;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\expenseController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\staffController;

Route::group(['middleware'=>'islogin'],function(){

    Route::get('/', function() {
        return view('static');
    })->name('static');

    
//Brands

Route::get('/brands', [brandsController::class, 'index'])->name('brands');
Route::post('brandsupdate', [brandsController::class, 'store']);
Route::post('brandsedit', [brandsController::class, 'edit']);
Route::post('brandsdelete', [brandsController::class, 'destroy']);

//Clients

Route::get('clientsdata', [clientsController::class, 'index'])->name('clients');
Route::post('clientsupdate', [clientsController::class, 'store']);
Route::post('clientsedit', [clientsController::class, 'edit']);
Route::post('clientsdelete', [clientsController::class, 'destroy']);

//Expense

Route::get('expensedata', [expenseController::class, 'index'])->name('expense');
Route::post('expenseupdate', [expenseController::class, 'store']);
Route::post('expenseedit', [expenseController::class, 'edit']);
Route::post('expensedelete', [expenseController::class, 'destroy']);

//Products

Route::get('productsdata', [productsController::class, 'index'])->name('products');
Route::post('productsupdate', [productsController::class, 'store']);
Route::post('productsedit', [productsController::class, 'edit']);
Route::post('productsdelete', [productsController::class, 'destroy']);

//Orders

Route::get('ordersdata', [ordersController::class, 'index'])->name('orders');
Route::post('ordersupdate', [ordersController::class, 'store']);
Route::post('ordersedit', [ordersController::class, 'edit']);
Route::post('ordersdelete', [ordersController::class, 'destroy']);
Route::post('orderstesdiq', [ordersController::class, 'tesdiq']);
Route::post('orderslevg', [ordersController::class, 'levg']);

//Admin 

Route::get('admindata', [adminController::class, 'index'])->name('admin');
Route::post('adminupdate', [adminController::class, 'store']);
Route::post('adminedit', [adminController::class, 'edit']);
Route::post('admindelete', [adminController::class, 'destroy']);
Route::post('adminblok', [adminController::class, 'blok']);
Route::post('adminunblok', [adminController::class, 'unblok']);

//Staff

Route::get('staffdata', [staffController::class, 'index'])->name('staff');
Route::post('staffupdate', [staffController::class, 'store']);
Route::post('staffedit', [staffController::class, 'edit']);
Route::post('staffdelete', [staffController::class, 'destroy']);

//Excel

Route::get('/bexport',[brandsController::class,'export']);
Route::get('/cexport',[clientsController::class,'export']);
Route::get('/eexport',[expenseController::class,'export']);
Route::get('/pexport',[productsController::class,'export']);
Route::get('/oexport',[ordersController::class,'export']);
Route::get('/sexport',[staffController::class,'export']);

// PDF

Route::get('/pdf',[brandsController::class,'pdf'])->name('pdf');

//Logout web START

Route::get('/cixis',[userController::class,'logout']);

//Profile web START

Route::get('/profile', function() {
    return view('profile');
})->name('profile');

Route::post('/profile',[profileController::class,'update']);

});


Route::group(['middleware'=>'notlogin'],function(){

//Login

Route::post('/giris',[userController::class,'login']);

Route::get('/giris', function() {
    return view('login');
})->name('login');


//Register

Route::post('/qeydiyyat',[userController::class,'register']);

Route::get('/qeydiyyat', function() {
    return view('register');
})->name('register');

});