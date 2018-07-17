<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Plan;
use DB;
use Session;



class planController extends Controller
{
    //

    public function ingresarContenido($idAsignatura,$idSemana,$index){


        $idM = base64_decode($idAsignatura);
        $idS = base64_decode($idSemana);
        $asignatura = DB::table('t_cat_asignatura')
            ->select('as_nombre')
            ->where('as_id', '=', '' . $idM . '')
            ->get();

        $contenidos=planController::getContent($idS,$idM);
        $numCreditos=planController::getCredits($idM);
        $indexs=[];
        $stateNew=false;
        $horasOcupadas=0;
        if (!empty($contenidos)){
            $horasOcupadas=planController::getHoursAsign($contenidos);
            $indexs=planController::getIndex($contenidos);
            if ($index<0) {
                $index=count($indexs)-1;
            }
            if(($index+1)>count($indexs) && $horasOcupadas<$numCreditos){
                $stateNew=true;

            }else{
                $stateNew=false;
                if(($index+1)>count($indexs)){
                    $index=0;
                    Session::now('message', 'Límite de horas para la semana alcanzado, no puede ingresar nuevo contenido por el momento');
                    Session::now('alert-class', 'alert-danger');
                }

            }
        }else{
            $index=0;
        }
        return view('semanas.semana1', ["asignatura" => $asignatura,"idA"=>$idM,"contenidos"=> $contenidos,"idS"=>$idS,"indexs"=>$indexs,"index"=>$index,"numCreditos"=>$numCreditos,"stateNew"=>$stateNew,"horasOcupadas"=>$horasOcupadas]);

    }

    public function indexTemas(Request $request){

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


            return view('Docente.Indextemas', ["consulta_docentes" => $consulta_docentes]);
        }
    }


    public function getTemas(){


        return view('Docente.verTemas');
    }
    public function vistaPlanificacionCurso(){


        return view('Docente.planificacionCurso');
    }

    public function getContenido(Request $request){

        $semana=$request->get('semanas');
        $contenido=DB::table('contenidos')
            ->select('id','semana','descripcion')
            ->where('semana','=','' . $semana . '')
            ->get();

        return response()->json($contenido);
    }

    public function getAllTemas(Request $request){

        $idContenido=$request->get('contenido');
        $temas=DB::table('temas')
            ->join('contenidos','contenidos.id','=','temas.id_contenido')
            ->select('contenidos.id','temas.id','temas.tema')
            ->where('temas.id_contenido','=',''.$idContenido.'')
            ->get();

        return response()->json($temas);

    }

    public function verSemanas($id){

        $idM = base64_decode($id);
        return view('Docente.verSemanas',["idA"=>$idM]);

    }

    private static function getContent($idSemana,$idAsignatura){
        $query="select * from contenidosemana where semana= ".$idSemana." AND id_asignatura= ".$idAsignatura." AND user_id =".Auth::user()->id."";
        $contenidos= DB::select(DB::raw($query));
        return $contenidos;
    }
    private static function getCredits($idAsignatura){
        $numHoras=DB::table('t_cat_asignatura')
            ->select('as_num_credito')
            ->where('as_id', '=', '' . $idAsignatura .'')
            ->get();


        return $numHoras[0]->as_num_credito;
    }
    private static function getHoursAsign($contenidos){
        $total=0;
        foreach ($contenidos as $content => $value) {
            $total+=$value->horas_asignadas;
        }

        return $total;
    }
    private static function getIndex($contenidos){
        $index=[];
        foreach ($contenidos as $content => $value) {
            $index[]=$value->id;
        }
        $index = array_unique($index);
        $ind=array_values($index);
        return $ind;
    }


    public function savePlan(Request $request){

        if ($request->isMethod('post')) {


            $contenido = $request->input('contenidoS1');
            $listaTemas = $request->input('listaTemas');
            $id=$request->input('idAsignatura');
            $semana=$request->input('semana');

            /* $idAsignatura=DB::table('t_docente_asignaturas')
                 ->select('asig_id')
                 ->where('dasg_id','=',''.$idDoceAsig.'')
                 ->get();
             foreach ($idAsignatura as $valores){

                 $id=$valores->asig_id;

             }*/

            $saveContenido=DB::table('contenidos')->insert([
                'semana' => $semana,
                'descripcion' => $contenido,
                'estado' => 'Disponible',
                'id_asignatura' => $id,
            ]);
            /////
            $ultimoIdContenido = DB::table('contenidos')->max('id');
            $arrayLista = json_decode($listaTemas);

            foreach ($arrayLista as $temas) {
                $tema=$temas->tema;
                $horasAsignadas=$temas->hasig;
                $porcAprobacion=$temas->papro;
                $prioridad=$temas->prioridad;


                $saveTemas=DB::table('temas')->insert([
                    'tema'=>$tema,
                    'estado'=>"activo",
                    'prioridad'=>$prioridad,
                    'id_contenido'=>$ultimoIdContenido,

                ]);

                $ultimoIdTemas = DB::table('temas')->max('id');
                $savePlan=DB::table('plan')->insert([
                    'id_tema'=>$ultimoIdTemas,
                    'horas_asignadas'=>$horasAsignadas,
                    'porcentaje_aprobacion'=> $porcAprobacion,
                    'estado'=>"activo",

                ]);

            }

        }




    }
}
