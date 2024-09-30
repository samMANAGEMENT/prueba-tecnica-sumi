<?php

namespace App\Http\Modulos\Task\Model;

use App\Http\Modulos\Projects\Model\Projects;
use App\Http\Modulos\User\Model\User;
use App\Http\Modulos\State\Model\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'fecha_final', 'project_id', 'user_id', 'state_id'];


    public function project() {
        return $this->belongsTo(Projects::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }
}
