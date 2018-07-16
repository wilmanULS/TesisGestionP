<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class formato extends Model
{
    //
    use CrudTrait;

    protected $table='formato';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['descripcion'];


}