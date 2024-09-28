<?php

use App\Http\Modulos\State\Controller\StateController;
use Illuminate\Support\Facades\Route;

Route::prefix('state', 'throttle:60,1')->group(function () {
    Route::controller(StateController::class)->group(function () {
        Route::post('crear', 'CrearState');
        Route::get('listar', 'ListarState');
    }
);
}
);
