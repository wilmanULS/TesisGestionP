<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelCognoscitivo extends Model
{
    protected $table = "nivelcognoscitivo";
    public $timestamps = false;
    protected $primary_key = 'id';
    protected $filename = ['id','dificultad', 'descripcion'];


    public static function getDificultad()
    {

        $dificultad=DB::table('nivelcognoscitivo')
            ->select('nivelcognoscitivo.dificultad')
            ->distinct()
            ->get();

    }

}


