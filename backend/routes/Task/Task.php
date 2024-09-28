<?php

use App\Http\Modulos\Task\Controller\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('task', 'throttle:60,1')->group(function () {
    Route::controller(TaskController::class)->group(function () {
        Route::post('crear', 'CrearTask');
        Route::get('listar', 'ListarTask');
        Route::put('actualizar/{id}', 'actualizarTask');
        Route::delete('eliminar/{id}', 'eliminarTask');
    }
);
}
);
