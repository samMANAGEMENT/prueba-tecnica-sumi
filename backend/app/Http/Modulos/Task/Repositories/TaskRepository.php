<?php

namespace App\Http\Modulos\Task\Repositories;

use App\Http\Modulos\Task\Model\Task;

class TaskRepository
{
    public function CrearTask(array $data) {
        return Task::create($data);
    }

    public function ListarTask() {
        return Task::with(['project', 'user', 'state'])
            ->select('id', 'nombre', 'descripcion', 'fecha_final', 'project_id', 'user_id', 'state_id')
            ->get();
    }

    public function actualizarTask(int $id, array $data) {
        $task = Task::find($id);
        if (!$task) {
            throw new \Exception("La tarea no fue encontrada.");
        }

        $task->update(array_merge($data, [
            'state_id' => $data['state_id'] ?? $task->state_id
        ]));

        return $task;
    }


    public function eliminarTask(int $id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return true;
        }
        return false;
    }
}
