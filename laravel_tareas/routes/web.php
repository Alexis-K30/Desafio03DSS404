<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/tareas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tareas', TareaController::class)->except(['show']);
    Route::post('/tareas/{id}/estado', [TareaController::class, 'cambiarEstado'])->name('tareas.estado');
});

require __DIR__.'/auth.php';