<?php

use App\Http\Modulos\Projects\Controller\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')->group(function () {
    Route::middleware('throttle:60,1')->group(function () {
        Route::controller(ProjectsController::class)->group(function () {
            Route::post('crear', 'CrearProjecto');
            Route::get('listar', 'ListarProjecto');
            Route::put('actualizar/{id}', 'actualizarProyecto');
            Route::delete('eliminar/{id}', 'eliminarProyecto');
        });
    });
});


