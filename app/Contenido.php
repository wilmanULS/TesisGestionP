<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    const ESTADO_COMPLETO = 'Completo';
    //
    protected $table = "contenidos";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id', 'descripcion', 'id_competencias', 'semana', 'estado'];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura', 'as_id');
    }
}
