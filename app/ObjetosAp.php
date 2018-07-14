<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjetosAp extends Model
{
    //
    protected $table = "objetos_aprendizaje";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','titulo','descripcion','evaluacion_profesor','estado',
        'nd_id','dt_id','cf_id','tr_id','kw_id','tema_id'];
}
