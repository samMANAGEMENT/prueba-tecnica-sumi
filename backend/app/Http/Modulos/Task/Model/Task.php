<?php

namespace App\Http\Modulos\Task\Model;

use App\Http\Modulos\Projects\Model\Projects;
use App\Http\Modulos\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_final', 'project_id', 'user_id'];


    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id'); //PROJECT PERTENECE A ID
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id'); // PERTENECE A ID (ASIGNADO)
    }
}
