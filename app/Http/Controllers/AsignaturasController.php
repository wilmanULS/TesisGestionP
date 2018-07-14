<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asignatura;
use App\Http\Requests;
use DB;

class AsignaturasController extends Controller
{



    public function index()
    {
        /* $asignaturas = DB::select('CALL SP_ListaMaterias');

         $array = json_decode(json_encode($asignaturas), true);

         foreach ($array as $valor)
         {
         $nuevo[]=$valor;
         }*/

        $nuevo = DB::table('t_cat_asignatura')
            ->where('as_estado', '=', 1)
            ->orWhere('as_estado', '=', 2)
            ->select('as_id', 'as_nombre', 'as_nivel', 'as_num_credito', 'as_estado')
            ->groupBy('as_nombre')
            ->orderBy('as_id')
            ->paginate(7);
        return view('Administrador.IndexAsignatura', ['asignaturas' => $nuevo]);//->with(compact('asignaturas',$nuevo));
    }

    public function create()
    {
        $asignaturasNivel = DB::table('t_cat_asignatura as asig')
            ->select('as_nivel')
            ->distinct()
            ->get();

        return view('Administrador.createMateria', ['NivelAsignatura' => $asignaturasNivel]);
    }

    public function saveAsignatura(Request $request)
    {

        if ($request->isMethod('post')) {
            $NombreAsignatura = $request->input('NombreAsignatura');
            $NivelAsignatura = $request->input('NivelAsignatura');
            $CreditoAsignatura = $request->input('CreditoAsignatura');
            $EstadoAsig = 1;

            $verificacion = DB::table('t_cat_asignatura')
                ->select('as_nombre')
                ->where('as_nombre', '=', $NombreAsignatura)
                ->get();
            if (count($verificacion) > 0) {
                echo false;
            } else {
                DB::table('t_cat_asignatura')->insert([
                    'as_nombre' => $NombreAsignatura,
                    'as_nivel' => $NivelAsignatura,
                    'as_num_credito' => $CreditoAsignatura,
                    'as_estado' => $EstadoAsig,
                ]);
                echo true;
            }


        }
    }

    public function updateAsignatura(Request $request)
    {

        if ($request->isMethod('post')) {
            $idAsig = $request->input('idAsignatura');
            $NombreAsignatura = $request->input('NombreAsignatura');
            $NivelAsignatura = $request->input('NivelAsignatura');
            $CreditoAsignatura = $request->input('CreditoAsignatura');
            $EstadoAsig = $request->input('EstadoAsignatura');
            DB::table('t_cat_asignatura')
                ->where('as_id', '=', $idAsig)
                ->update([
                    'as_nombre' => $NombreAsignatura,
                    'as_nivel' => $NivelAsignatura,
                    'as_num_credito' => $CreditoAsignatura,
                    'as_estado' => $EstadoAsig,
                ]);
        }
    }

    function editAsignatura($id)
    {
        $idAsig = base64_decode($id);
        $asignaturasNivel = DB::table('t_cat_asignatura as asig')
            ->select('as_nivel')
            ->distinct()
            ->get();

        $asignatura = DB::table('t_cat_asignatura')
            ->select('as_id', 'as_nombre', 'as_nivel', 'as_num_credito', 'as_estado')
            ->where('as_id', '=', '' . $idAsig . '')
            ->get();
        $array = json_decode(json_encode($asignatura), true);
        $data = $array[0];

        return view('Administrador.editMateria', ['Asignatura' => $data, 'NivelAsignatura' => $asignaturasNivel]);


    }








	
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
