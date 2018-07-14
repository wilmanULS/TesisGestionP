<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TDocenteAsignatura extends Model
{
    protected $table='t_docente_asignaturas';
    protected  $primaryKey='dasg_id';
    public $timestamps=false;

    protected $fillable=[

       'id_periodo',
        'user_id',
        'asig_id',
        'dasg_id',

    ];
}
