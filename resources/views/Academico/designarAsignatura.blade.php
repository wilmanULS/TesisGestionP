@extends('backpack::layout')
@section('header')
    <h1 class=content-header">
        <i class=""></i>Asignar
        <a href="../create" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i>
            <span>Añadir nuevo</span> </a>
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
                                    <th>Id</th>
                                    <th>Docentes</th>
                                    <th>Asignatura</th>
                                    <th>Nivel</th>
                                    <th>Asignatura Antecesora</th>
                                    <th>Acciones de la tabla</th>
                                </tr>
                                </thead>
                                @foreach($consulta_docentes as $doc)
                                    <tr>
                                        <td>{{$doc->dasg_id}}</td>
                                        <td>{{$doc->name}}</td>
                                        <td>{{$doc->as_nombre}}</td>
                                        <td>{{$doc->as_nivel}}</td>
                                        <td>{{$doc->as_antecesor}}</td>
                                        <td>
                                            <a name="Eliminar" id="{{$doc->dasg_id}}'"
                                               class="btn btn-sm btn-danger pull-right delete"><i
                                                        class="voyager-trash"></i><span>Borrar</span></a>
                                            <a href="edit/{{$doc->dasg_id}}" title="Editar"
                                               class="btn btn-sm btn-primary pull-right edit"><i
                                                        class="voyager-edit"></i> <span>Editar</span></a>

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
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            if (confirm("esta seguro de querer eliminar este objeto "+ id)) {
                $.ajax({
                    url: "{{route('Asignatura.delete')}}",
                    method: "get",
                    data: {
                        id: id
                    }, success: function (msg) {
                        alert("Se ha eliminado con exito " + msg);
                      location.href='/Academico/designarAsignatura';
                    }
                })

            } else {
                return false;
            }
        });

    </script>


@endsection





