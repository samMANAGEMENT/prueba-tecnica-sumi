<?php

namespace App\Http\Modulos\State\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Modulos\Task\Model\Task;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function tasks() {
        return $this->hasMany(Task::class, 'state_id'); //RELACION CON LA TABLA TASK PARA STATE
    }
}
