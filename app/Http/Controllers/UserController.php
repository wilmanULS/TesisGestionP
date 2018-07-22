<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\User;
use App\TDocenteAsignatura;
use DB;

class UserController extends Controller
{
    //
    public function index(Request $request)
    { //revise como parametro un request


        $idDocentes=DB::table('model_has_roles')
            ->select('model_id')
            ->where('role_id','=','2')
            ->distinct()
            ->get();

        $arrayLista = json_decode($idDocentes);


        for($i=0; $i<count($arrayLista); $i++) {

            $catDocentes = DB::table('users')
                ->select('id', 'name')
                ->where('id', '=', '' . $arrayLista[$i]->model_id . '')
                ->distinct()
                ->get();
        $arrayName=json_decode(json_encode($catDocentes),true);
        $catalagoDocentes[]=$arrayName[0];

        }





        $nivel = DB::table('t_cat_asignatura')
            ->select('t_cat_asignatura.as_nivel')
            ->distinct()
            ->get();

        $periodos=DB::table('periodo_academico')
            ->select('id','estado','name')
            ->distinct()
            ->get();




        return view("create", ["catDocentes" => $catalagoDocentes, "nivel" => $nivel,'periodos'=>$periodos]);
    }

    public function Edit($id) // nos muestra el formulario
    {


        $idDocentes=DB::table('model_has_roles')
            ->select('model_id')
            ->where('role_id','=','2')
            ->distinct()
            ->get();

        $arrayLista = json_decode($idDocentes);


        for($i=0; $i<count($arrayLista); $i++) {

            $catDocentes = DB::table('users')
                ->select('id', 'name')
                ->where('id', '=', '' . $arrayLista[$i]->model_id . '')
                ->distinct()
                ->get();
            $arrayName=json_decode(json_encode($catDocentes),true);
            $catalagoDocentes[]=$arrayName[0];

        }

        $nivel = DB::table('t_cat_asignatura')
            ->select('t_cat_asignatura.as_nivel')
            ->distinct()
            ->get();

        $busqueda = TDocenteAsignatura::findOrFail($id);

        return view("Academico.edit", ["catDocentes" => $catalagoDocentes, "nivel" => $nivel, "busqueda" => $busqueda]);
    }

    public function actualizar(Request $request) // modifica por GET
    {

        if ($request->isMethod('post')) {

            $id = $request->get('id');
            $docenteModelo = TDocenteAsignatura::findOrFail($id);
            $array = $docenteModelo->attributesToArray();
            $asigID = $array['asig_id'];
            ///
            $periodo = $request->get('periodo');

            $asigNID = $request->get('idAsignatura');

            $asignatura = DB::table('t_cat_asignatura')
                ->where('as_id', '=', $asigID)
                ->update(['as_estado' => 1]);
            $asignaturaN = DB::table('t_cat_asignatura')
                ->where('as_id', '=', $asigNID)
                ->update(['as_estado' => 0]);

            $resultado = DB::table('t_docente_asignaturas')->where('dasg_id', '=', $id)
                ->update(['id_periodo' => $periodo,

                    'asig_id' => $asigNID]);

        }
    }

    public function delete(Request $request, $id) // elimina
    {
        $docenteModelo = TDocenteAsignatura::findOrFail($id);
        $docenteModelo->delete();
    }

}
