<?php

namespace App\Http\Modulos\Task\Repositories;

use App\Http\Modulos\Task\Model\Task;

class TaskRepository
{
    public function CrearTask(array $data) {
        return Task::create($data);
    }

    public function ListarTask() {
        return Task::select('id', 'nombre', 'descripcion')->get();
    }

    public function actualizarTask(int $id, array $data) {
        $proyecto = Task::find($id);
        if (!$proyecto) {
            throw new \Exception("La tarea no fue encontrada.");
        }
        $proyecto->update($data);
        return $proyecto;
    }

    public function eliminarTask(int $id)
    {
        $proyecto = Task::find($id);
        if ($proyecto) {
            $proyecto->delete();
            return true;
        }
        return false;
    }
}
