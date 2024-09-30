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

    public function CrearState(Request $request) { //CREA ESTADO
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $this->projectsRepository->CrearState($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function ListarState(Request $request) {//TRAE ESTADO
        try {
            $listar = $this->projectsRepository->ListarState();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function actualizarState(Request $request, $id) { //ACTUALIZA ESTADO
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
            ]);

            $proyectoActualizado = $this->projectsRepository->actualizarState($id, $validatedData);
            return response()->json($proyectoActualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function eliminarState($id) //ELIMINA ESTADO
    {
        try {
            $eliminado = $this->projectsRepository->eliminarState($id);
            if ($eliminado) {
                return response()->json(['message' => 'Proyecto eliminado con éxito'], Response::HTTP_OK);
            }
            return response()->json(['error' => 'Proyecto no encontrado'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }
}
