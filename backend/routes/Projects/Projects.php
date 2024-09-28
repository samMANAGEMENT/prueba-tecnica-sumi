<?php

use App\Http\Modulos\Projects\Controller\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects', 'throttle:60,1')->group(function () {
    Route::controller(ProjectsController::class)->group(function () {
        Route::post('crear', 'CrearProjecto');
        Route::get('listar', 'ListarProjecto');
    }
);
}
);
