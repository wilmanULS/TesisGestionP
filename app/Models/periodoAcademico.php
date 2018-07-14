<?php

namespace App\Models;;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class periodoAcademico extends Model
{
    //
    use CrudTrait;

    protected $table='periodo_academico';
    protected $primary_key = 'id';
    public $timestamps =false;
    protected $fillable = ['name','estado'];


}
