<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomia extends Model
{
    //
    protected $table = "taxonomia_blooms";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','verbo', 'estado','id_cg'];
}
