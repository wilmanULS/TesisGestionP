@extends('backpack::layout')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-documentation"></i>Ingresar Objetos Aprendizaje
    </h1>
@stop
@section('content')

    <div class="page-content container-fluid">

        <div class="panel panel-bordered">

            <div class="panel-body">
                <input type="hidden" value="{{csrf_token()}}" id="token"/>

            <div class="form-group col-md-6">

                <label for="name">Seleccione Semana</label>
                <select name='semanas' class="form-control" id="semanas">
                    <option>Seleccionar</option>
                    @for($i=1; $i<17; $i++)
                        <option value='{{$i}}'>semana {{$i}}</option>

                    @endfor
                </select>
            </div>
                <div class="form-group col-md-6">

                    <label for="name">Seleccione Contenido</label>
                    <select name='contenido' class="form-control" id="contenido">

                        <option value='Seleccionar'>Seleccionar</option>
                    </select>
                </div>
                <br>

                <label for="name" class="page-title">Lista de Temas</label><br>

                <div class="panel-footer" id="tablavista">
                    <table id="Asignados" class="table table-striped database-tables">
                        <thead>
                        <tr>
                            <th>Temas</th>
                            <th>Acciones de la tabla</th>
                        </tr>
                        </thead>

                    </table>

                </div>

        </div>

        </div>

    </div>



@stop
@section('scripts')
    <script>
        semanaContenido();

        TemasContenido();

        function semanaContenido () {

            $('#semanas').change(function () {
                if ($(this).val() != '') {


                    var semanas = $('#semanas').val();
                    var token = $('token').val();

                    $.ajax({
                        type: "get",
                        url: "{{ route('Docente.temas') }}",
                        data: {
                            semanas: semanas,
                            token: token

                        }, success: function (data) {
                            console.log('success');

                            console.log(data);

                            //console.log(data.length);
                            $('#contenido').empty();
                            $('#contenido').append('<option value="">' + ' Seleccionar' + '</option>');
                            for (var i = 0; i < data.length; i++) {
                                $('#contenido').append('<option value="' + data[i].id + '">' + data[i].descripcion + '</option>');

                            }


                        }


                    });

                }
            });
        }

        function TemasContenido () {

            $('#contenido').change(function () {
                if ($(this).val() != '') {


                    var contenido = $('#contenido').val();
                    var token = $('token').val();

                    $.ajax({
                        type: "get",
                        url: "{{ route('Docente.verTemas') }}",
                        data: {
                            contenido: contenido,
                            token: token

                        }, success: function (data) {
                            console.log('sip');

                            console.log(data);
                            //console.log(data.length);

                            $('#tablavista').empty();
                            var content = "<table id='Asignados' class='table table-striped database-tables'>";
                            content +="<thead>" +
                                "                        <tr>" +
                                "                            <th>Temas</th>" +
                                "                            <th>Acciones de la tabla</th>" +
                                "                        </tr>" +
                                "                        </thead>";
                            for(i=0; i<data.length; i++){
                                content += '<tr><td>' + data[i].tema + '</td>' +
                                    '<td>' + 'result ' +  i + '</td>' +
                                    '<td><a href="/Repositorio/ingresarOA/'+data[i].id+'" class="btn btn-sm btn-primary pull-right edit"><i class="voyager-edit"></i></a>'
                                    '</tr>';
                            }
                            content += "</table>"

                            $('#tablavista').append(content);


                        }


                    });

                }
            });
        }


    </script>


@stop