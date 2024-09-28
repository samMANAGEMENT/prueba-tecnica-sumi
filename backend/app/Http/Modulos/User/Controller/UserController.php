<?php

namespace App\Http\Modulos\User\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(private UserRepository $projectsRepository)
    {
    }

    public function CrearUser(Request $request) {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'required|date',
                'fecha_final' => 'required|date|after:fecha_inicio',
                'project_id' => 'required|integer|exists:projects,id',
            ]);
                        $this->projectsRepository->CrearUser($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ListarUser(Request $request){ // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $listar =  $this->projectsRepository->ListarUser();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizarUser(Request $request, $id) {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $proyectoActualizado = $this->projectsRepository->actualizarUser($id, $validatedData);
            return response()->json($proyectoActualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function eliminarUser($id)
    {
        try {
            $eliminado = $this->projectsRepository->eliminarUser($id);
            if ($eliminado) {
                return response()->json(['message' => 'Proyecto eliminado con éxito'], Response::HTTP_OK);
            }
            return response()->json(['error' => 'Proyecto no encontrado'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
