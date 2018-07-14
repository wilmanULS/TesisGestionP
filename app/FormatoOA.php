<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoOA extends Model
{
    //
    protected $table = "formato";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','descripcion'];
}
