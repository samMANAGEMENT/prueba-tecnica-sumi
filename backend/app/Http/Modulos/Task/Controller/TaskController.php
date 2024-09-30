<?php

namespace App\Http\Modulos\Task\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\Task\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function CrearTask(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_final' => 'required|date|after:fecha_inicio',
                'project_id' => 'required|integer|exists:projects,id',
                'user_id' => 'required|integer|exists:users,id',
                'state_id' => 'nullable|integer|exists:states,id',
            ]);

            $this->taskRepository->CrearTask($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ListarTask(Request $request) {
        try {
            $listar = $this->taskRepository->ListarTask();
            return response()->json($listar->map(function ($task) {
                return [
                    'id' => $task->id,
                    'nombre' => $task->nombre,
                    'descripcion' => $task->descripcion,
                    'fecha_final' => $task->fecha_final,
                    'project' => $task->project ? $task->project->nombre : 'Sin proyecto',
                    'user' => $task->user ? $task->user->email : 'Sin usuario',
                    'estado' => $task->state ? $task->state->nombre : 'Sin estado',
                ];
            }));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Error al listar tareas'], 500);
        }
    }

    public function actualizarTask(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_final' => 'nullable|date|after:fecha_inicio',
                'project_id' => 'required|integer|exists:projects,id',
                'user_id' => 'required|integer|exists:users,id',
                'state_id' => 'nullable|integer|exists:states,id',
            ]);

            $proyectoActualizado = $this->taskRepository->actualizarTask($id, $validatedData);
            return response()->json($proyectoActualizado, Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getMessage() === "La tarea no fue encontrada.") {
                return response()->json(['error' => 'La tarea con el ID proporcionado no existe.'], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function eliminarTask($id)
    {
        try {
            $eliminado = $this->taskRepository->eliminarTask($id);
            if ($eliminado) {
                return response()->json(['message' => 'Tarea eliminada con éxito'], Response::HTTP_OK);
            }
            return response()->json(['error' => 'Tarea no encontrada'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
