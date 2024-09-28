<?php

namespace App\Http\Modulos\Projects\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Modulos\Projects\Repositories\ProjectsRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectsController extends Controller
{
    public function __construct(private ProjectsRepository $projectsRepository) {}

    public function CrearProjecto(Request $request)
    { // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $this->projectsRepository->CrearProjecto($request->all());
            return response()->json('Se ha creado con exito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function ListarProjecto(Request $request)
    { // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $listar =  $this->projectsRepository->ListarProjecto();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizarProyecto(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_final' => 'required|date|after:fecha_inicio',
                'estado_id' => 'required|integer|exists:states,id',
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $proyectoActualizado = $this->projectsRepository->actualizarProyecto($id, $validatedData);
            return response()->json($proyectoActualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function eliminarProyecto($id)
    {
        try {
            // Verificar si el proyecto tiene tareas asociadas
            $tareasCount = DB::table('tasks')->where('project_id', $id)->count();

            if ($tareasCount > 0) {
                return response()->json(['error' => 'No se puede eliminar el proyecto porque tiene tareas asociadas.'], Response::HTTP_BAD_REQUEST);
            }

            // Llamar al repositorio para eliminar el proyecto
            $eliminado = $this->projectsRepository->eliminarProyecto($id);

            if ($eliminado) {
                return response()->json(['message' => 'Proyecto eliminado con éxito'], Response::HTTP_OK);
            }

            return response()->json(['error' => 'Proyecto no encontrado'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Error al eliminar el proyecto'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
