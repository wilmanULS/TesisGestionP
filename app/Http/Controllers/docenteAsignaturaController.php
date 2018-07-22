<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TDocenteAsignatura;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\docenteAsignaturaFormRequest;
use DB;

class docenteAsignaturaController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    { //revise como parametro un request
        if ($request) {
            $query = trim($request->get('searchText'));
            $consulta_docentes = DB::table('t_docente_asignaturas as d')
                ->join('users', 'users.id', '=', 'd.user_id')
                ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
                ->select('d.dasg_id', 'users.name', 't_cat_asignatura.as_nombre', 't_cat_asignatura.as_nivel', 't_cat_asignatura.as_antecesor')
                ->where('users.name', 'LIKE', '%' . $query . '%')
                //campo del fltro, comando SQL, texto a buscar
                ->orderBy('d.dasg_id', 'desc')
                ->paginate(7);


            return view('Academico.designarAsignatura', ["consulta_docentes" => $consulta_docentes, "searchText" => $query]);
        }
    }

    public function getPeriodos(Request $request){



    }



    public function create() // es la vista
    {
        return view('/create');
    }

    public function saveDocAsigDB(Request $request)
    {


        if ($request->isMethod('post')) {


            $idDocente = $request->input('idDocente');
            $idAsignatura = $request->input('idAsignatura');
            $periodo = $request->input('periodo');


            $editState = DB::table('t_cat_asignatura')->where('as_id', $idAsignatura)->update([
                'as_estado' => 0

            ]);

            $addDA = DB::table('t_docente_asignaturas')->insert([
                'id_periodo' => $periodo,
                'user_id' => $idDocente,
                'asig_id' => $idAsignatura,

            ]);

        }
    }

    public function store(docenteAsignaturaFormRequest $request) //es como el insert
    {
        $docenteModelo = new TDocenteAsignatura;
        // modelo-formulario
        $docenteModelo->id_periodo = $request->get('periodo');

        $docenteModelo->user_id = $request->get('iddocentes');
        $docenteModelo->asig_id = $request->get('idAsignatura');
        $docenteModelo->save();

        return Redirect::to('Academico/designarAsignatura');
    }

    public function show($id) //se recupera los datos de un registro en particular
    {

        return view("Academico.show", ["resultado" => TDocenteAsignatura::findOrFail($id)]);
    }

    public function edit($id) // nos muestra el formulario
    {
        return view("Academico.edit", ["resultado" => TDocenteAsignatura::findOrFail($id)]);
    }

    public function update(docenteAsignaturaFormRequest $request, $id) // modifica por GET
    {
        $docenteModelo = TDocenteAsignatura::findOrFail($id);
        $docenteModelo->dasg_codigo = $request->get('codigo'); // modelo-formulario
        $docenteModelo->dasg_fecha_inicio = $request->get('fechaIni');
        $docenteModelo->dasg_fecha_fin = $request->get('fechaFin');
        $docenteModelo->user_id = $request->get('usuarioID');
        $docenteModelo->asig_id = $request->get('asignaturaID');
        $docenteModelo->update();
        return Redirect::to('Academico/edit');
    }

    public function delete(Request $request) // elimina
    {
        $docenteModelo = TDocenteAsignatura::findOrFail($request->input('id'));
        $array = $docenteModelo->attributesToArray();
        $asigID = $array['asig_id'];

        $asignatura = DB::table('t_cat_asignatura')
            ->where('as_id', '=', $asigID)
            ->update(['as_estado' => 1]);

        if ($docenteModelo->delete()) {
            echo 'Data eliminada';
        }

    }

}



