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

    Route::get('/dashboard/clientes',[ClienteController::class,'index'])->name('dashboard.clientes.index');
    Route::get('/dashboard/clientes/create',[ClienteController::class,'create'])->name('dashboard.clientes.create');
    Route::post('/dashboard/clientes',[ClienteController::class,'store'])->name('dashboard.clientes.store');

});

require __DIR__.'/auth.php';
