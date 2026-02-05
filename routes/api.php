<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PropietarioController;


// Rutas para Propietarios
Route::prefix('propietarios')->group(function () {
    Route::get('/', [PropietarioController::class, 'index']);           // GET /api/propietarios
    Route::post('/', [PropietarioController::class, 'store']);          // POST /api/propietarios
    Route::get('/{id}', [PropietarioController::class, 'show']);        // GET /api/propietarios/{id}
    Route::put('/{id}', [PropietarioController::class, 'update']);      // PUT /api/propietarios/{id}
    Route::delete('/{id}', [PropietarioController::class, 'destroy']);  // DELETE /api/propietarios/{id}
});

// Rutas para Animales
Route::prefix('animales')->group(function () {
    Route::get('/', [AnimalController::class, 'index']);           // GET /api/animales
    Route::post('/', [AnimalController::class, 'store']);          // POST /api/animales
    Route::get('/{id}', [AnimalController::class, 'show']);        // GET /api/animales/{id}
    Route::put('/{id}', [AnimalController::class, 'update']);      // PUT /api/animales/{id}
    Route::delete('/{id}', [AnimalController::class, 'destroy']);  // DELETE /api/animales/{id}
});
