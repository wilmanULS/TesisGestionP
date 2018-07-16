<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class nivelCognoscitivo extends Model
{
    //
    use CrudTrait;

    protected $table='nivelcognoscitivo';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['descripcion','dificultad'];


}