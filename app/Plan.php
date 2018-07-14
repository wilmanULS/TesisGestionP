<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $table = "plan";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','id_tema','horas_asignadas','horas_impratidas','porcentaje_aprobacion','estado'];
}
