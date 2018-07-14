<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    //
    protected $table = "contenidos";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','descripcion','id_competencias','semana','estado'];
}
