<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class recursoEducativo extends Model
{
    //
    use CrudTrait;

    protected $table='tipo_recurso_educativo';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['descripcion'];


}