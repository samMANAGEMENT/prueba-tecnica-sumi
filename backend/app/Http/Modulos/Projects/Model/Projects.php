<?php

namespace App\Http\Modulos\Projects\Model;

use App\Http\Modulos\State\Model\State;
use App\Http\Modulos\Task\Model\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_final', 'estado_id', 'user_id'];


    public function UserRelation() { //Relacion Estado
        return $this->belongsTo(User::class,  'user_id');
    }

    public function TaskRelation() { //Relacion Estado
        return $this->hasMany(Task::class);
    }

    public function StateRelation() { //Relacion Estado
        return $this->belongsTo(State::class,   'estado_id');
    }
}
