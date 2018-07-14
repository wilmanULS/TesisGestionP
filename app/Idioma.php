<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{

    protected $table = "idioma";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','descripcion'];
    //
}
