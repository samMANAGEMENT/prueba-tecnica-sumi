<?php

namespace App\Http\Modulos\Task\Repositories;

use App\Http\Modulos\Task\Model\Task;

class TaskRepository
{
    public function CrearTask(array $data) {
        return Task::create($data);
    }

    public function ListarTask() {
        return Task::with(['project', 'user'])
            ->select('id', 'nombre', 'descripcion', 'fecha_final', 'project_id', 'user_id')
            ->get();
    }



    public function actualizarTask(int $id, array $data) {
        $task = Task::find($id);
        if (!$task) {
            throw new \Exception("La tarea no fue encontrada.");
        }
        $task->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'fecha_final' => $data['fecha_final'],
            'project_id' => $data['project_id'],
            'user_id' => $data['user_id'],
        ]);

        return $task;
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
