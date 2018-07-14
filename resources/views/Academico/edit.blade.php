@extends('backpack::layout')

@section('header')
    <h1 class="content-header">
        <i class=""></i>Editar

    </h1>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div class="form-group col-md-12">

                <label for="name">Docente</label>
                <select name='iddocentes' class="form-control" id="idDocente">
                    @foreach($catDocentes as $docentes)
                        @if($docentes->id==$busqueda->user_id)
                            <option value='{{$docentes->id}}' selected>{{$docentes->name}}</option>
                        @else
                            <option value='{{$docentes->id}}'>{{$docentes->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>


            <div class="form-group col-md-12">

                <label for="name">Nivel</label>
                <select name='idnivel' class="form-control" id='nivel'>

                    <option placeholder="seleccionar" value='Seleccionar'>Seleccionar</option>
                    @foreach($nivel as $n)
                        @if($n->as_nivel==$busqueda->as_nivel)
                            <option value='{{$n->as_nivel}}' selected>{{$n->as_nivel}}</option>
                        @else
                            <option value='{{$n->as_nivel}}'>{{$n->as_nivel}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12">

                <label for="name">Asignatura</label>
                <select name='idAsignatura' class="form-control" id='asignatura'>

                    <option value='Seleccionar'>Seleccionar</option>


                </select>
            </div>
            <div class="form-group col-md-12">

                <label for="name">Fecha de Inicio</label>
                <input required type="date" class="form-control" name="fecha_ini"
                       value="{{$busqueda->desg_fecha_inicio}}" id="fecha_ini">
            </div>
            <div class="form-group col-md-12">

                <label for="name">Fecha de Finalización</label>
                <input required type="date" class="form-control" name="fecha_fin"
                       value="{{$busqueda->desg_fecha_inicio}}" id="fecha_fin">
            </div>


            <div class="form-group">
                <button class="btn btn-primary update" id='{{$busqueda->dasg_id}}' type="submit">Guardar</button>
                <button class="btn btn-danger cancel" id="cancelar" type="reset">Cancelar</button>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>

        $('#nivel').change(function (event) {
            $.get("/create/asignaturas/" + event.target.value + "", function (response, state) {
                console.log(response);
                $('#asignatura').empty();
                for (i = 0; i < response.length; i++) {
                    $('#asignatura').append("<option value='" + response[i].as_id + "'>" + response[i].as_nombre + "</option>")
                }

            });

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#cancelar').on('click', function () {
            location.href = '/Academico/designarAsignatura';
        })
        $(document).on('click', '.update', function () {

            console.log('aqui');

            var id = $(this).attr('id');
            var idDocente = $('#idDocente').val();
            var idAsignatura = $('#asignatura').val();
            var fecha_ini = $('#fecha_ini').val();
            var fecha_fin = $('#fecha_fin').val();
            var token = $('token').val();
            $.ajax({
                url: "{{route('Academico.update')}}",
                method: "post",
                data: {
                    id: id,
                    idDocente: idDocente,
                    idAsignatura: idAsignatura,
                    fecha_ini: fecha_ini,
                    fecha_fin: fecha_fin,
                    token: token

                }, success: function (msg) {
                    alert("Se ha actulizado con exito " + msg);
                    location.href = '/Academico/designarAsignatura';
                }
            });
        });

    </script>
@endsection

