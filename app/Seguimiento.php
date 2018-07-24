<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    protected $table = 'seguimiento';
    protected $primary_key = 'id';
    public $timestamps = false;
    protected $fillable = ['semana_actual', 'horas_impartidas', 'horas_restantes', 'fecha_creacion'];

}