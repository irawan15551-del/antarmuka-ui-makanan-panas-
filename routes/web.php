<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\MachineConfigurationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\KioskController;

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

    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.process');

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

    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Role Testing
    |--------------------------------------------------------------------------
    */

    Route::get('/admin-test', function () {
        return 'Halaman Admin berhasil diakses.';
    })
        ->middleware('role:admin')
        ->name('admin.test');

    Route::get('/operator-test', function () {
        return 'Halaman Operator berhasil diakses.';
    })
        ->middleware('role:operator')
        ->name('operator.test');

    Route::get('/admin-operator-test', function () {
        return 'Halaman Admin dan Operator berhasil diakses.';
    })
        ->middleware('role:admin,operator')
        ->name('admin-operator.test');


    /*
    |--------------------------------------------------------------------------
    | Product Management - Admin & Operator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,operator')->group(function () {

        Route::get('/products', [
            ProductController::class,
            'index',
        ])->name('products.index');

        Route::get('/products/{product}', [
            ProductController::class,
            'show',
        ])
            ->whereNumber('product')
            ->name('products.show');

    });


    /*
    |--------------------------------------------------------------------------
    | Product Management - Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get('/products/create', [
            ProductController::class,
            'create',
        ])->name('products.create');

        Route::post('/products', [
            ProductController::class,
            'store',
        ])->name('products.store');

        Route::get('/products/deleted', [
            ProductController::class,
            'deleted',
        ])->name('products.deleted');

        Route::post('/products/{id}/restore', [
            ProductController::class,
            'restore',
        ])
            ->whereNumber('id')
            ->name('products.restore');

        Route::get('/products/{product}/edit', [
            ProductController::class,
            'edit',
        ])
            ->whereNumber('product')
            ->name('products.edit');

        Route::put('/products/{product}', [
            ProductController::class,
            'update',
        ])
            ->whereNumber('product')
            ->name('products.update');

        Route::patch('/products/{product}', [
            ProductController::class,
            'update',
        ])
            ->whereNumber('product')
            ->name('products.update.patch');

        Route::delete('/products/{product}', [
            ProductController::class,
            'destroy',
        ])
            ->whereNumber('product')
            ->name('products.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | Admin & Operator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,operator')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Restock
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
                'update',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Machine Configuration
        |--------------------------------------------------------------------------
        */

        Route::get('/machine', [
            MachineConfigurationController::class,
            'index',
        ])->name('machine.index');

        Route::post('/machine', [
            MachineConfigurationController::class,
            'store',
        ])->name('machine.store');

        /*
         * Route konfirmasi diletakkan sebelum machine/{machine}.
         * Parameter ID bersifat opsional.
         */

        Route::get('/machine/confirm/{id?}', [
            MachineConfigurationController::class,
            'confirm',
        ])
            ->whereNumber('id')
            ->name('machine.confirm');

        Route::get('/machine/{machine}', [
            MachineConfigurationController::class,
            'show',
        ])
            ->whereNumber('machine')
            ->name('machine.show');


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        Route::get('/activities', [
            ActivityController::class,
            'index',
        ])->name('activities.index');


        /*
        |--------------------------------------------------------------------------
        | Kiosk Touchscreen
        |--------------------------------------------------------------------------
        */

        Route::prefix('kiosk')
            ->name('kiosk.')
            ->controller(KioskController::class)
            ->group(function () {

                Route::get('/splash', 'splash')
                    ->name('splash');

                Route::get('/dashboard', 'dashboard')
                    ->name('dashboard');

                Route::get('/products', 'products')
                    ->name('products');

                Route::get('/product-detail', 'productDetail')
                    ->name('product-detail');

                Route::get('/machine-status', 'machineStatus')
                    ->name('machine-status');

                Route::get('/configuration', 'configuration')
                    ->name('configuration');

                Route::post('/configuration-result', 'configurationResult')
                    ->name('configuration-result');

                Route::get(
                    '/configuration-result/{id}',
                    'showConfigurationResult'
                )
                    ->whereNumber('id')
                    ->name('configuration-result.show');

                Route::get('/settings', 'settings')
                    ->name('settings');

            });

    });


    /*
    |--------------------------------------------------------------------------
    | User Management - Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::resource('users', UserController::class)
            ->except(['show']);

    });

});