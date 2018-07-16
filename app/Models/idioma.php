<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class idioma extends Model
{
    //
    use CrudTrait;

    protected $table='idioma';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['descripcion'];


}