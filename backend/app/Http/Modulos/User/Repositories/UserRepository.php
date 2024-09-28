<?php

namespace App\Http\Modulos\User\Repositories;

use App\Http\Modulos\User\Model\User;

class UserRepository
{
    public function CrearUser(array $data) {
        return User::create($data);
    }

    public function ListarUser() {
        return User::select('id', 'name', 'email')->get(); // Cambiar 'nombre' a 'name'
    }

    public function actualizarUser(int $id, array $data) {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception("El usuario no fue encontrado.");
        }
        $user->update($data);
        return $user;
    }

    public function eliminarUser(int $id)
    {
        $proyecto = User::find($id);
        if ($proyecto) {
            $proyecto->delete();
            return true;
        }
        return false;
    }
}
