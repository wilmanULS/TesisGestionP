<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class seguimientoController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        //select asignatura
        $queryAsignatura = DB::table('t_docente_asignaturas as d')
            ->select('t_cat_asignatura.as_id as id', 't_cat_asignatura.as_nombre as text')
            ->join('users', 'users.id', '=', 'd.user_id')
            ->join('t_cat_asignatura', 't_cat_asignatura.as_id', '=', 'd.asig_id')
            ->where('d.user_id', '=', '' . $userId . '')
            ->orderBy('d.dasg_id', 'desc')->pluck('text', 'id')->toArray();
        return view('seguimiento.index', ["asignaturas" => $queryAsignatura]);
    }

    public function getContenidosByAsignatura($asignaturaId = null)
    {
        $query = DB::table('contenidos as c')
            ->select('c.id', DB::raw('concat(c.descripcion," (semana ",c.semana,")") as descripcion'))
            ->where('c.id_asignatura', '=', $asignaturaId)->get()->toArray();
        return json_encode($query);
    }

    public function getPlanesByContenido($contenidoId = null)
    {
        $query = DB::table('plan as pl')
            ->select('pl.id',
                'temas.tema',
                'pl.horas_asignadas',
                DB::raw('ifnull(sum(seguimiento.horas_impartidas),0) as horas_impartidas'),
                'pl.estado')
            ->join('temas', 'temas.id', '=', 'pl.id_tema')
            ->leftJoin('seguimiento', 'pl.id', '=', 'seguimiento.plan_id')
            ->where('temas.id_contenido', '=', $contenidoId)
            ->groupBy('pl.id')->get()->toArray();
        return json_encode($query);
    }

    public function getFormRegistrarHoras($planId = null)
    {
        $modal = view('seguimiento._modal_horas', ['planId' => $planId])->render();
        return json_encode($modal);
    }

    public function postSaveFormRegistrarHoras($planId = null)
    {
        $result = [];
        try {
            DB::beginTransaction();
            $input = Input::all();
            if (isset($input['n_horas']) && $input['n_horas']) {
                $modelPlan = Plan::findOrFail($planId);
                $queryHorasImpartidas = DB::table('seguimiento as se')
                    ->select(DB::raw('ifnull(sum(se.horas_impartidas),0) as horas_impartidas'))
                    ->where('se.plan_id', '=', $planId)->get()->toArray();
                $horasImpartidas = (int)$queryHorasImpartidas[0]->horas_impartidas;
                $horasRestantes = (int)$modelPlan->horas_asignadas - $horasImpartidas;
                if ($horasRestantes > 0) {
                    if ($horasRestantes >= (int)$input['n_horas']) {
                        $modelContenido = $modelPlan->tema->contenido;
                        $modelAsignatura = $modelContenido->asignatura;
                        $horasAsignatura = (int)$modelAsignatura->as_num_creditos;
                        //////////
                        $model = new Seguimiento();
                        $model->semana_actual = $modelContenido->semana;
                        $model->horas_impartidas = $input['n_horas'];
                        $model->fecha_creacion = date('Y-m-d H:i:s');
                        $model->plan_id = $planId;
                        $model->save();
                        $result['success'] = true;
                    } else {
                        $result['success'] = false;
                        $result['message'] = 'Ha superado el límite de horas asignadas al tema.';
                    }
                } else {
                    $result['success'] = false;
                    $result['message'] = 'Se ha cumplido el límite de horas impartidas para este tema.';
                }
            } else {
                $result['success'] = false;
                $result['message'] = 'Campo Nº Horas requerido';
            }
            DB::commit();
            return json_encode($result);
        } catch (\Exception $e) {
            DB::rollback();
            $result['success'] = false;
            $result['message'] = 'Ocurrió un error al intentar registrar las horas, intente nuevamente...';
            return json_encode($result);
        }

    }

}
