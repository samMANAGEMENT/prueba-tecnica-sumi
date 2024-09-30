<?php

namespace App\Http\Modulos\User\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function __construct(private UserRepository $projectsRepository) {}

    public function CrearUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8',
            ]);

            if (empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt('defaultpassword'); // DEFECTO YA QUE NO USE LOGIN
            } else {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            $this->projectsRepository->CrearUser($validatedData);
            return response()->json('Se ha creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function ListarUser(Request $request) //LISTA USERS DEL REPO
    {
        try {
            $listar =  $this->projectsRepository->ListarUser();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizarUser(Request $request, $id)
    {
        try {

            $user = $this->projectsRepository->find($id); //BUSCO ID

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id), //VALIDO DATOS
                ],
                'password' => 'nullable|string|min:8',
            ]);

            $proyectoActualizado = $this->projectsRepository->actualizarUser($id, $validatedData);
            return response()->json($proyectoActualizado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }


    public function eliminarUser($id) //ELIMINA USER LLAMANDO AL REPO
    {
        try {
            $eliminado = $this->projectsRepository->eliminarUser($id);
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
