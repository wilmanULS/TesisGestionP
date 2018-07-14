@extends('backpack::layout')

@section('header')
    <h1 class="content-header">
        <i class="fa fa-cog"></i> Mis Asignaturas
    </h1>
@endsection

@section('content')
    <div class="page-content container-fluid">
        
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
                                    <th>Docente</th>
                                    <th>Asignatura</th>
                                    <th>Nivel</th>

                                    <th>Acciones de la tabla</th>
                                </tr>
                                </thead>
                                @foreach($consulta_docentes as $doc)
                                    <tr>
                                        <td>{{$doc->name}}</td>
                                        <td>{{$doc->as_nombre}}</td>
                                        <td>{{$doc->as_nivel}}</td>

                                        <td>
                                            <a href="funciones/contenido/{{base64_encode($doc->dasg_id)}}" title="definirContenido"
                                               class="btn btn-xs btn-default" id="{{$doc->dasg_id}}"><i
                                                        class="fa fa-edit"></i> <span>Registrar Horas y Competencias</span></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                        </div>

                        {{$consulta_docentes->render()}}
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

    </script>


@endsection





