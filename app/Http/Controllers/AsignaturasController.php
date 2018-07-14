<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asignatura;
use App\Http\Requests;
use DB;

class AsignaturasController extends Controller
{

	
    public function getAsignature(Request $request, $nivel){
        if($request->ajax()){
         
           $asignatura=Asignatura::asignature($nivel);
            return response()->json($asignatura);

        }

    }
    public function getNombre(Request $request, $id){
        if($request->ajax()){
            $asignatura=Asignatura::asignatureID($id);
            return response()->json($asignatura);
        }
    }
}
