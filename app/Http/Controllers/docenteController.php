<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TDocenteAsignatura;
use Illuminate\Support\Facades\Auth;
use App\Asignatura;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;

class docenteController extends Controller
{

    public function index(Request $request)
    { //revise como parametro un request

        $userId = Auth::user()->getAuthIdentifier();

        if ($request) {

            $consulta_docentes = DB::table('t_docente_asignaturas as d')
                ->join('users', 'users.id', '=', 'd.user_id')
                ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
                ->select('d.dasg_id', 'users.name', 't_cat_asignatura.as_nombre', 't_cat_asignatura.as_nivel', 't_cat_asignatura.as_antecesor', 'd.user_id')
                ->where('user_id', '=', '' . $userId . '')
                //campo del fltro, comando SQL, texto a buscar
                ->orderBy('d.dasg_id', 'desc')
                ->paginate(7);



            return view('Docente.contenidoCompetencias', ["consulta_docentes" => $consulta_docentes]);
        }
    }

    public function definirContenido($id)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $idM = base64_decode($id);

        $asignatura = DB::table('t_docente_asignaturas as d')
            ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
            ->select('d.dasg_id', 'd.user_id', 'd.asig_id', 't_cat_asignatura.as_nombre')
            ->where('d.dasg_id', '=', '' . $idM . '')
            ->get();

        $dificultad = DB::table('nivelcognoscitivo')
            ->select('nivelcognoscitivo.dificultad')
            ->distinct()
            ->get();


        return view('Docente.funciones', ["dificultad" => $dificultad, "asignatura" => $asignatura, "idA" => $idM]);


    }

    public function tablaCompetencias(Request $request)
    { //revise como parametro un request

        $userId = Auth::user()->getAuthIdentifier();

        if ($request) {

            $competencias = DB::table('t_docente_asignaturas as d')
                ->join('users', 'users.id', '=', 'd.user_id')
                ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
                ->join('asignatura_horas', 'asignatura_horas.dasg_id', '=', 'd.dasg_id')
                ->join('competencias', 'competencias.id_horas', '=', 'asignatura_horas.id')
                ->select('d.dasg_id', 'users.name', 't_cat_asignatura.as_nombre', 'competencias.descripcion','competencias.id', 't_cat_asignatura.as_nivel', 't_cat_asignatura.as_antecesor', 'd.user_id')
                ->where('user_id', '=', '' . $userId . '')
                //campo del fltro, comando SQL, texto a buscar
                ->orderBy('d.dasg_id', 'desc')
                ->paginate(7);


            return view('Docente.competencias', ["competencias" => $competencias]);
        }
    }

    public function edit($id) // nos muestra el formulario
    {
        $idM = base64_decode($id);

        $editCompetenicas = DB::table('t_docente_asignaturas as d')
            ->join('users', 'users.id', '=', 'd.user_id')
            ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
            ->select('d.dasg_id', 'users.name', 't_cat_asignatura.as_nombre', 't_cat_asignatura.as_nivel', 't_cat_asignatura.as_antecesor', 'd.user_id')
            ->where('d.dasg_id', '=', '' . $id . '');

        $asignatura = DB::table('t_docente_asignaturas as d')
            ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
            ->select('d.dasg_id', 'd.user_id', 'd.asig_id', 't_cat_asignatura.as_nombre')
            ->where('d.dasg_id', '=', '' . $idM . '')
            ->get();

        $dificultad = DB::table('nivelcognoscitivo')
            ->select('nivelcognoscitivo.dificultad')
            ->distinct()
            ->get();


        return view("Docente.editarCompetencias", ["editCompetenicas" => $editCompetenicas]);
    }

}
