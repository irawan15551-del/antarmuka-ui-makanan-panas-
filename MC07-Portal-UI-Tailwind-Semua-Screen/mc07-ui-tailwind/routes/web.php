<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\MachineConfigurationController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn()=>redirect()->route('login'));
Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.process');
});
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::middleware('role:admin,operator')->group(function(){
        Route::get('/products/deleted',[ProductController::class,'deleted'])->name('products.deleted');
        Route::post('/products/{id}/restore',[ProductController::class,'restore'])->name('products.restore');
        Route::resource('products',ProductController::class);
        Route::get('/restock',[fn()=>view('restock.index')])->name('restock.index');
        Route::get('/slots',[fn()=>view('slots.index')])->name('slots.index');
        Route::get('/approvals',[ApprovalController::class,'index'])->name('approvals.index');
        Route::get('/machine',[MachineConfigurationController::class,'index'])->name('machine.index');
        Route::post('/machine',[MachineConfigurationController::class,'store'])->name('machine.store');
        Route::get('/machine/confirm',[MachineConfigurationController::class,'confirm'])->name('machine.confirm');
        Route::get('/activities',[ActivityController::class,'index'])->name('activities.index');
    });

    Route::middleware('role:admin')->group(function(){
        Route::resource('users',UserController::class)->only(['index','create','store','edit','update']);
    });
});
