<?php

namespace App\Http\Modulos\State\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\State\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    public function __construct(private StateRepository $projectsRepository)
    {
    }

    public function CrearState(Request $request) {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $this->projectsRepository->CrearState($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function ListarState(Request $request) {
        try {
            $listar =  $this->projectsRepository->ListarState();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
