<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/clientes',[ClienteController::class,'index'])->name('dashboard.clientes.index')
    ->can('dashboard.clientes.index');
    Route::get('/dashboard/clientes/create',[ClienteController::class,'create'])->name('dashboard.clientes.create')
    ->can('dashboard.clientes.create');
    Route::post('/dashboard/clientes',[ClienteController::class,'store'])->name('dashboard.clientes.store')
    ->can('dashboard.clientes.store');
    Route::get('/dashboard/clientes/{cliente}/edit',[ClienteController::class,'edit'])->name('dashboard.clientes.edit')
    ->can('dashboard.clientes.edit');
    Route::get('/dashboard/clientes/{cliente}',[ClienteController::class,'show'])->name('dashboard.clientes.show')
    ->can('dashboard.clientes.show');
    Route::put('/dashboard/clientes/{cliente}',[ClienteController::class,'update'])->name('dashboard.clientes.update')
    ->can('dashboard.clientes.update');
    Route::delete('/dashboard/clientes/{cliente}',[ClienteController::class,'destroy'])->name('dashboard.clientes.destroy')
    ->can('dashboard.clientes.destroy');
});

require __DIR__.'/auth.php';
