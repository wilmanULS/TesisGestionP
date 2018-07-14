<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dificultad extends Model
{
    //
    protected $table = "dificultad";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','descripcion'];
}
