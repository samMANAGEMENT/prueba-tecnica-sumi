<?php

namespace App\Http\Modulos\Projects\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modulos\Projects\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectsController extends Controller
{
    public function __construct(private ProjectsRepository $projectsRepository)
    {

    }

    public function CrearProjecto(Request $request){ // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $this->projectsRepository->CrearProjecto($request->all());
            return response()->json('Se ha creado con exito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function ListarProjecto(Request $request){ // FUNCION LLAMA AL REPOSITORY PARA CREAR EL PROYECTO
        try {
            $listar =  $this->projectsRepository->ListarProjecto();
            return response()->json($listar);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
