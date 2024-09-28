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

    public function EditarState(array $data){
        return State::deleted($data);
    }
}
