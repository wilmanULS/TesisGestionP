<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class dificultad extends Model
{
    //
    use CrudTrait;

    protected $table='dificultad';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['descripcion'];


}