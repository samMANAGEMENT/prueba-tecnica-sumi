<?php

namespace App\Http\Modulos\State\Repositories;

use App\Http\Modulos\State\Model\State;

class StateRepository
{
    public function CrearState(array $data) {
        return State::create($data);
    }


    public function ListarState(){
        $listar = State::select('id', 'nombre')
        ->get();
        return $listar;
    }

    public function actualizarState(int $id, array $data) {
        $proyecto = State::find($id);
        if (!$proyecto) {
            throw new \Exception("El proyecto no fue encontrado.");
        }
        $proyecto->update($data);
        return $proyecto;
    }

    public function eliminarState(int $id)
    {
        $proyecto = State::find($id);
        if ($proyecto) {
            $proyecto->delete();
            return true;
        }
        return false;
    }
}
