<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    //
    protected $table = "temas";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','tema','id_contenido','prioridad','estado','precendetes','sucedentes'];

    public function contenido()
    {
        return $this->belongsTo(Contenido::class, 'id_contenido');
    }
}
