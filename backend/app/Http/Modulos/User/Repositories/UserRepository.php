<?php

namespace App\Http\Modulos\User\Repositories;

use App\Http\Modulos\User\Model\User;

class UserRepository
{
    public function CrearUser(array $data)
    { //CREO USER CON EL MODEL
        return User::create($data);
    }

    public function ListarUser()
    {
        return User::select('id', 'name', 'email')->get(); //TRAE LISTA PERO SOLO DATOS ESPECIFICOS
    }

    public function actualizarUser(int $id, array $data)
    { //ACTUALIZA USER
        $user = User::find($id); //BUSCA POR ID
        if (!$user) {
            throw new \Exception("El usuario no fue encontrado.");
        }
        $user->update($data); //ACTUALIZA DATOS CON LA DATA QUE ENVIA
        return $user;
    }

    public function find($id) //BUSCA ID CUANDO NO SE EDITAN TODOS LOS CAMPOS
    {
        return User::findOrFail($id);
    }

    public function eliminarUser(int $id) // ELIMINA USER POR ID
    {
        $user = User::with(['tareas', 'proyectos'])->find($id);

        if (!$user) {
            throw new \Exception("El usuario no fue encontrado.");
        }
        if ($user->tareas()->count() > 0 || $user->proyectos()->count() > 0) {
            throw new \Exception("No se puede eliminar el usuario porque tiene tareas o proyectos asociados.");
        }

        $user->delete();
        return true;
    }
}
