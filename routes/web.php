<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\MachineConfigurationController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});


/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Role Testing
    |--------------------------------------------------------------------------
    */

    Route::get('/admin-test', function () {
        return 'Halaman Admin berhasil diakses.';
    })->middleware('role:admin');

    Route::get('/operator-test', function () {
        return 'Halaman Operator berhasil diakses.';
    })->middleware('role:operator');

    Route::get('/admin-operator-test', function () {
        return 'Halaman Admin dan Operator berhasil diakses.';
    })->middleware('role:admin,operator');


    /*
    |--------------------------------------------------------------------------
    | Admin & Operator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,operator')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Product Management
        |--------------------------------------------------------------------------
        */

        Route::get('/products/deleted', [ProductController::class, 'deleted'])
            ->name('products.deleted');

        Route::post('/products/{id}/restore', [ProductController::class, 'restore'])
            ->name('products.restore');

        Route::resource('products', ProductController::class);


        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Restock / Stock
        |--------------------------------------------------------------------------
        */

        Route::get('/restock', function () {
            return view('restock.index');
        })->name('restock.index');


        /*
        |--------------------------------------------------------------------------
        | Slot Mapping
        |--------------------------------------------------------------------------
        */

        Route::get('/slots', function () {
            return view('slots.index');
        })->name('slots.index');


        /*
        |--------------------------------------------------------------------------
        | Approval Queue
        |--------------------------------------------------------------------------
        */

        Route::resource('approvals', ApprovalController::class)
            ->only([
                'index',
                'show',
                'update'
            ]);


        /*
        |--------------------------------------------------------------------------
        | Machine Configuration
        |--------------------------------------------------------------------------
        */

        Route::resource('machine', MachineConfigurationController::class)
            ->only([
                'index',
                'store',
                'show'
            ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        Route::resource('activities', ActivityController::class)
            ->only([
                'index'
            ]);

    });

});