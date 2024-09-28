<?php

namespace App\Http\Modulos\Task\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\Task\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct(private TaskRepository $projectsRepository)
    {
    }

    public function CrearTask(Request $request) {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'nullable|date',
                'fecha_final' => 'nullable|date|after:fecha_inicio',
                'project_id' => 'required|integer|exists:projects,id',
            ]);
            $this->projectsRepository->CrearTask($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function ListarTask(Request $request){ // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $listar =  $this->projectsRepository->ListarTask();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizarTask(Request $request, $id) {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
            ]);

            // Llama al repositorio para actualizar
            $proyectoActualizado = $this->projectsRepository->actualizarTask($id, $validatedData);

            return response()->json($proyectoActualizado, Response::HTTP_OK);

        } catch (\Exception $e) {
            if ($e->getMessage() === "El proyecto no fue encontrado.") {
                return response()->json(['error' => 'El estado con el ID proporcionado no existe.'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function eliminarTask($id)
    {
        try {
            $eliminado = $this->projectsRepository->eliminarTask($id);
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
