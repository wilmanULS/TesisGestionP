<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Contenido;
use App\Plan;
use App\Seguimiento;
use App\Tema;
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
        $modelAsignatura = Asignatura::where('as_id', $asignaturaId)->first();
        $query = DB::table('contenidos as c')
            ->select('c.id',
                DB::raw('concat(concat(c.descripcion," (semana ",c.semana,")"),if(c.estado="' . Contenido::ESTADO_COMPLETO . '"," (impartido)","")) as descripcion'))
            ->where('c.id_asignatura', '=', $asignaturaId)->orderBy('c.semana')->get()->toArray();
        //get semana actual
        $queryLastSeguimiento = DB::table('seguimiento as se')
            ->select('se.id', 'se.horas_restantes', 'se.semana_actual')
            ->join('plan as pl', 'pl.id', '=', 'se.plan_id')
            ->join('temas as te', 'te.id', '=', 'pl.id_tema')
            ->join('contenidos as co', 'co.id', '=', 'te.id_contenido')
            ->where('co.id_asignatura', $asignaturaId)
            ->orderBy('se.fecha_creacion', 'desc')->first();
        if ($queryLastSeguimiento) {
            if ((int)$queryLastSeguimiento->horas_restantes === 0) {
                $queryLastSeguimiento->semana_actual += 1;
                $horasRestantes = $modelAsignatura->as_num_credito;
            } else {
                $horasRestantes = $queryLastSeguimiento->horas_restantes;
            }
        } else {
            $horasRestantes = $modelAsignatura->as_num_credito;
        }
        return json_encode(['query' => $query,
            'semana_actual' => $queryLastSeguimiento ? $queryLastSeguimiento->semana_actual : 1,
            'horas_restantes' => $horasRestantes,
            'horas_semana' => $modelAsignatura->as_num_credito,
        ]);
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
                    ->where('se.plan_id', $planId)->get()->toArray();
                $horasImpartidas = (int)$queryHorasImpartidas[0]->horas_impartidas;
                $horasRestantes = (int)$modelPlan->horas_asignadas - $horasImpartidas;
                if ($horasRestantes > 0) {
                    if ($horasRestantes >= (int)$input['n_horas']) {
                        $modelContenido = $modelPlan->tema->contenido;
                        $modelAsignatura = $modelContenido->asignatura;
                        $horasAsignatura = (int)$modelAsignatura->as_num_credito;
                        //get last seguimiento register
                        $query = DB::table('seguimiento as se')
                            ->select('se.id', 'se.horas_restantes')
                            ->join('plan as pl', 'pl.id', '=', 'se.plan_id')
                            ->join('temas as te', 'te.id', '=', 'pl.id_tema')
                            ->join('contenidos as co', 'co.id', '=', 'te.id_contenido')
                            ->where('co.id_asignatura', $modelAsignatura->as_id)
                            ->orderBy('se.fecha_creacion', 'desc')->first();
                        //get last semana del plan
                        $queryLastSemanaPlan = DB::table('seguimiento as se')
                            ->select('se.id', 'se.semana_actual')
                            ->where('se.plan_id', $planId)
                            ->orderBy('se.fecha_creacion', 'desc')->first();
                        $lastSemanaPlan = $queryLastSemanaPlan ? $queryLastSemanaPlan->semana_actual : $modelContenido->semana;
                        $horasRestantesSemana = $query ? $query->horas_restantes : $horasAsignatura;
                        if ($horasRestantesSemana === 0 || $horasRestantesSemana >= (int)$input['n_horas']) {
                            $model = new Seguimiento();
                            $model->semana_actual = $horasRestantesSemana === 0 ? ($queryLastSemanaPlan ? ($lastSemanaPlan + 1) : $lastSemanaPlan) : $lastSemanaPlan;
                            $model->horas_impartidas = $input['n_horas'];
                            $model->horas_restantes = $horasRestantesSemana === 0 ? ($horasAsignatura - (int)$input['n_horas']) : ($horasRestantesSemana - (int)$input['n_horas']);
                            $model->fecha_creacion = date('Y-m-d H:i:s');
                            $model->plan_id = $planId;
                            $model->save();
                            //actualizar estado del tema si horas restantes=0
                            if ($horasRestantes - (int)$input['n_horas'] === 0) {
                                $modelTema = $modelPlan->tema;
                                $modelTema->estado = Contenido::ESTADO_COMPLETO;
                                $modelTema->save();
                            }
                            //actualizar estado del contenido si horas restantes=0
                            $modelTemasIncompletos = Tema::where('id_contenido', $modelContenido->id)->where('estado', '<>', Contenido::ESTADO_COMPLETO)->first();
                            if (!$modelTemasIncompletos) {
                                $modelContenido->estado = Contenido::ESTADO_COMPLETO;
                                $modelContenido->save();
                            }
                            $result['success'] = true;
                        } else {
                            $result['success'] = false;
                            $result['message'] = 'Ha superado el límite de horas por semana.';
                        }
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
