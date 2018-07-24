@extends('backpack::layout')
@section('header')
    <h1 class="content-header">
        <i class=""></i>Seguimiento de Plan Académico
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <input type="hidden" value="{{csrf_token()}}" id="token"/>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">Seleccione Asignatura</label>
                <select name='asignatura' class="form-control" id="asignatura">
                    <option value=''>-- Seleccione --</option>
                    @foreach($asignaturas as $key => $asignatura)
                        <option value='{{$key}}'>{{$asignatura}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Seleccione Contenido</label>
                <select name='contenido' class="form-control" id="contenido">
                    <option value=''>-- Seleccione --</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form class="form-edit-add" role="form">

                        <!-- CSRF TOKEN -->
                        <div class="panel-footer">
                            <table id="seguimiento" class="table table-striped database-tables"></table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="container_modal_horas"></div>
    </div>
    <input id="action_get_contenidos" type="hidden"
           value="{{ action("seguimientoController@getContenidosByAsignatura") }}"/>
    <input id="action_get_planes" type="hidden"
           value="{{ action("seguimientoController@getPlanesByContenido") }}"/>
    <input id="action_get_form_horas" type="hidden"
           value="{{ action("seguimientoController@getFormRegistrarHoras") }}"/>
    <input id="action_save_form_horas" type="hidden"
           value="{{ action("seguimientoController@postSaveFormRegistrarHoras") }}"/>
@stop
@section('after_scripts')
    <script>
        $(function () {
            $('#asignatura').on('change', function (e) {
                getContenidos($(this).val());
            });
            $('#contenido').on('change', function (e) {
                getPlanes($(this).val());
            });
        });

        function getContenidos(asignaturaId) {
            $.ajax({
                type: "get",
                url: $('#action_get_contenidos').val() + '/' + asignaturaId,
                dataType: 'json',
                success: function (data) {
                    $('#contenido').empty();
                    $('#contenido').append('<option value="">' + ' -- Seleccione --' + '</option>');
                    for (var i = 0; i < data.length; i++) {
                        $('#contenido').append('<option value="' + data[i].id + '">' + data[i].descripcion + '</option>');
                    }
                }
            });
        }

        function getPlanes(contenidoId) {
            $.ajax({
                type: "get",
                url: $('#action_get_planes').val() + '/' + contenidoId,
                dataType: 'json',
                success: function (data) {
                    $('#seguimiento').empty();
                    var content = "<thead>" +
                        "<tr>" +
                        "<th>Tema</th>" +
                        "<th>Horas asignadas</th>" +
                        "<th>Horas impartidas</th>" +
                        "<th>Acciones de la tabla</th>" +
                        "</tr>" +
                        "</thead>";
                    for (var i = 0; i < data.length; i++) {
                        content += '<tr>' +
                            '<td>' + data[i].tema + '</td>' +
                            '<td>' + data[i].horas_asignadas + '</td>' +
                            '<td>' + data[i].horas_impartidas + '</td>' +
                            '<td>' + ((parseInt(data[i].horas_asignadas) === parseInt(data[i].horas_impartidas)) ? '' : '<a onclick="getModalHoras(' + data[i].id + ')" class="btn btn-sm btn-primary pull-right edit"><i class="voyager-edit"></i>Registrar Horas</a>') +
                            '</tr>';
                    }
                    content += "</table>"
                    $('#seguimiento').html(content);
                }
            });
        }

        function getModalHoras(planId) {
            $.ajax({
                type: "get",
                url: $('#action_get_form_horas').val() + '/' + planId,
                dataType: 'json',
                success: function (data) {
                    $('#container_modal_horas').html(data);
                    $('#modal_horas').modal('show');
                    $('#btn_save').on('click', function () {
                        saveHoras();
                    });
                }
            });
        }

        function saveHoras() {
            $.ajax({
                type: "post",
                url: $('#action_save_form_horas').val() + '/' + $('#modal_plan_id').val(),
                data: $('#form_horas').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('#modal_horas').modal('hide');
                        $('#contenido').change();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (e) {
                    alert('Ocurrió un error al registrar las horas, intente nuevamente...');
                    $('#modal_horas').modal('hide');
                }
            });
        }
    </script>
@stop





