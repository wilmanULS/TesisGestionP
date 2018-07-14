@extends('voyager::master')
@section('css')

@stop
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-group"></i>Asignaturas
        <a href="{{route('Administrador.createAsignatura')}}" class="btn btn-success btn-add-new"><i class="voyager-plus"></i>
            <span>Añadir nuevo</span> </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form class="form-edit-add" role="form">

                        <!-- CSRF TOKEN -->


                        <div class="panel-footer">
                            <table id="Asignados" class="table table-striped database-tables">
                                <thead>
                                <tr>
                                    <th>Asignatura</th>
                                    <th>Nivel</th>
                                    <th>Nº Creditos</th>
                                    <th>Estado</th>
                                    <th>Acciones de la tabla</th>
                                </tr>
                                </thead>
                                      @foreach($asignaturas as $valor)
                                          <tr>
                                              <td>{{$valor->as_nombre}}</td>
                                              <td>{{$valor->as_nivel}}</td>
                                              <td>{{$valor->as_num_credito}}</td>
                                              @if($valor->as_estado==1)
                                              <td>Inactivo</td>
                                                  @endif
                                              @if($valor->as_estado==2)
                                                  <td>Suspendida</td>
                                              @endif
                                              @if($valor->as_estado==0)
                                                  <td>Asignada</td>
                                              @endif
                                              <td>
                                                  <a name="Eliminar" id="{{$valor->as_id}}'"
                                                     class="btn btn-sm btn-danger pull-right delete"><i
                                                              class="voyager-trash"></i><span>Borrar</span></a>
                                                  <a href="/admin/indexAsignaturas/edit/{{base64_encode($valor->as_id)}}" title="Editar"
                                                     class="btn btn-sm btn-primary pull-right edit"><i
                                                              class="voyager-edit"></i> <span>Editar</span></a>

                                              </td>
                                          </tr>
                                      @endforeach
                            </table>

                        </div>

                         {{$asignaturas->render()}}
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>


                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

@stop





