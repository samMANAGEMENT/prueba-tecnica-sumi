<?php

use App\Http\Modulos\State\Controller\StateController;
use Illuminate\Support\Facades\Route;

Route::prefix('state')->middleware('throttle:60,1')->group(function () {
    Route::controller(StateController::class)->group(function () {
        Route::post('crear', 'CrearState');
        Route::get('listar', [StateController::class, 'ListarState']);
        Route::put('actualizar/{id}', 'actualizarState');
        Route::delete('eliminar/{id}', 'eliminarState');
    });
});
