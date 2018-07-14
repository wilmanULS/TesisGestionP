<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    //
    protected $table = "competencias";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','id_tax', 'descripcion','id_horas'];

}
