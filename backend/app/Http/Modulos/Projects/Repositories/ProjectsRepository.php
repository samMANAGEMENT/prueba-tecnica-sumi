<?php

namespace App\Http\Modulos\Projects\Repositories;

use App\Http\Modulos\Projects\Model\Projects;

class ProjectsRepository
{
    public function CrearProjecto(array $data){
        return Projects::create($data);
    }

    public function ListarProjecto(){
        $listar = Projects::select('id', 'nombre',  'descripcion', 'created_at', 'updated_at', 'user_id', 'estado_id')
        ->with(['StateRelation:id,nombre',  'UserRelation:id,email'])
        ->get();
        return $listar;
    }

    public function actualizarProyecto(int $id, array $data) {
        $proyecto = Projects::find($id);
        if (!$proyecto) {
            throw new \Exception("El proyecto no fue encontrado.");
        }
        $proyecto->update($data);
        return $proyecto;
    }

    public function eliminarProyecto(int $id)
    {
        $proyecto = Projects::find($id);
        if ($proyecto) {
            $proyecto->delete();
            return true;
        }
        return false;
    }

}
