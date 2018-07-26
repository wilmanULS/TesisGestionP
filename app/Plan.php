<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $table = "plan";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $fillable = ['id', 'id_tema', 'horas_asignadas', 'horas_impratidas', 'porcentaje_aprobacion', 'estado'];

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'id_tema');
    }
}
