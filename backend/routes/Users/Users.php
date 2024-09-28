<?php

use App\Http\Modulos\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->prefix('users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('crear', 'CrearUser');
        Route::get('listar', 'ListarUser');
        Route::put('actualizar/{id}', 'actualizarUser');
        Route::delete('eliminar/{id}', 'eliminarUser');
    });
});
