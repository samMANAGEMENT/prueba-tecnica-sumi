<?php

namespace App\Http\Modulos\Projects\Model;

use App\Http\Modulos\State\Model\State;
use App\Http\Modulos\Task\Model\Task;
use App\Http\Modulos\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_final', 'estado_id', 'user_id']; //SOLO ESTOS DATOS NECESITA PARA CREAR O ACTUALIZAR UN PROYECT


    public function UserRelation() { //PROYECTO PERTENECE A USER
        return $this->belongsTo(User::class,  'user_id');
    }

    public function TaskRelation() { //PROYECTO  TIENE 1 O MAS TAREAS ASOCIADAS
        return $this->hasMany(Task::class);
    }

    public function StateRelation() { //PROYECTO TIENE ESTADO
        return $this->belongsTo(State::class,   'estado_id');
    }
}
