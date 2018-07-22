@extends('backpack::layout')
@section('header')
    <h1 class="content-header">
        <i class=""></i>Planificación Curso
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
                            <th>Tema Antecesor</th>
                            <th>Tema Sucesor</th>
                            <th>Acciones de la tabla</th>
                        </tr>
                        </thead>

                    </table>

                </div>

                <div class="modal fade" id="ventana1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                               <h4 class="modal-title"> Agregar Temas Antecesores y Sucesores</h4>
                            </div>

                            <!-- header contenido-->

                            <div class="modal-body">
                                <label for="name">Seleccione Antesesor</label>
                                <select  class="form-control sel"  id="antesesor">

                                    <option value='Seleccionar'>Seleccionar</option>
                                </select>

                                <label for="name">Seleccione Sucesor</label>
                                <select  class="form-control sel" id="sucesor">

                                    <option value='Seleccionar'>Seleccionar</option>
                                </select>
                            </div>

                            <!-- footer-->
                            <div class="modal-footer">

                                <a class="btn btn-sm btn-primary saveAB" >Guardar</a>
                                <a class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</a>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>



@endsection
@section('scripts')
    <script>
        semanaContenido();
        TemasContenido();
        controlTemasAfterBefore();
        saveAfterBefore();


        function semanaContenido () {

            $('#semanas').change(function () {
                if ($(this).val() != '') {


                    var semanas = $('#semanas').val();
                    var token = $('#token').val();

                    $.ajax({
                        type: "get",
                        url: "{{ route('Docente.PlanCurso') }}",
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
                    var token = $('#token').val();

                    $.ajax({
                        type: "get",
                        url: "{{ route('Docente.verPlanCurso') }}",
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
                                "                             <th>Tema Antecesor</th>" +
                                "                             <th>Tema Sucesor</th>" +
                                "                            <th>Acciones de la tabla</th>" +
                                "                        </tr>" +
                                "                        </thead>";
                            for(i=0; i<data.length; i++){
                                content += '<tr><td>' + data[i].tema + '</td>' +
                                    '<td><a href="#ventana1" id="'+data[i].id+'" class="btn btn-sm btn-primary btn-lg add" data-target="#ventana1" data-toggle="modal">Añadir</a>'
                                '</tr>';
                            }
                            content += "</table>"

                            $('#tablavista').append(content);


                        }


                    });

                }
            });
        }

        function controlTemasAfterBefore(){
            $(document).on('click', '.add', function () {

                var idTema = $(this).attr('id');
                var contenido = $('#contenido').val();
                var token = $('#token').val();
                console.log(idTema);

                $.ajax({

                    type:"get",
                    url: "{{ route('Docente.Ant') }}",
                    data: {
                        contenido:contenido,
                        idTema: idTema,
                        token: token

                    }, success: function (data){
                        console.log('temas');
                        console.log(data);
                        $('#antesesor').empty();
                        $('#antesesor').append('<option value="Seleccionar">' + ' Seleccionar' + '</option>');
                        $('#antesesor').append('<option value="Ninguno">' + ' Ninguno' + '</option>');

                        $('#sucesor').empty();
                        $('#sucesor').append('<option value="Seleccionar">' + ' Seleccionar' + '</option>');
                        $('#sucesor').append('<option value="Ninguno">' + ' Ninguno' + '</option>');
                        for(i=0; i<data.length; i++) {
                            $('#antesesor').append('<option class="sel" value="' + data[i].tema + '">' + data[i].tema + '</option>');
                            $('#sucesor').append('<option class="sel" value="' + data[i].tema + '">' + data[i].tema + '</option>');
                        }
                    }



                });



            });
        }

        function saveAfterBefore(){
            $(document).on('click', '.saveAB', function () {

                var idTema = document.getElementsByClassName('add')[0].id;
                var antesesor=$('#antesesor').val();
                var sucesor=$('#sucesor').val();
                var token = $('#token').val();

                if(antesesor === sucesor)
                {
                    alert("Tema antecesor y sucesor iguales, realize un cambio");
                }
                else
                {
                    $.ajax({
                        type:"post",
                        url:"{{ route('Docente.saveAB')}}",
                        data:{
                            antesesor:antesesor,
                            sucesor:sucesor,
                            idTema:idTema,
                            token:token
                        }, success: function (){

                            alert('almacenado exitosamente');
                        }
                    });
                }
            });
        }
    </script>
@endsection