@extends('backpack::layout')
@section('header')
    <h1 class="content-header">
        <i class="voyager-documentation"></i>

        @foreach($asignatura as $as)
            {{$as->as_nombre}}
        @endforeach
        <input type="hidden" value="{{$idA}}" id="idDasg"/>
        <input type="hidden" value="{{$idNC}}" id="idNC"/>
        <input type="hidden" value="{{$idTax}}" id="idTax"/>
        <input type="hidden" value="{{$idHoras}}" id="idHoras"/>
        <input type="hidden" value="{{$dificult}}" id="dificult"/>
        <input type="hidden" value="{{$idComp}}" id="idComp"/>

    </h1>
@stop

@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">


            <h3>Actualizar Horas</h3>
            <div class="row">

                <div class="form-group col-md-4">
                    <label for="name">Horas Teóricas *</label>
                    <input required type="number" class="form-control required"
                           placeholder="N° Total de Horas" value="{{$horasT}}" id="horasT">
                </div>
                <div class="form-group col-md-4">

                    <label for="name">Horas Práctica *</label>
                    <input required type="number" class="form-control required"
                           placeholder="N° Total de Horas" value="{{$horasP}}" id="horasP">
                </div>
                <div class="form-group col-md-4">

                    <label for="name">Horas Laboratorio *</label>
                    <input required type="number" class="form-control required"
                           placeholder="N° Total de Horas" value="{{$horasL}}" id="horasL">

                    <input type="hidden" value="{{csrf_token()}}" id="token"/>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-bordered">
        <div class="panel-body">
            <h3>Actualizar Competencia</h3>
            <div id="competencias" class="row">
                <div id="CP" class="row">
                    <div class="form-group col-md-4">
                        <label for="name-2">Dificultad</label>
                        <select class="form-control dificultad" id="dificultad">
                            <option value='Seleccionar'>Seleccionar</option>
                            @foreach($dificultad as $dif)
                                <option value='{{$dif->dificultad}}'>{{$dif->dificultad}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name-2">Nivel Cognoscitivo</label>
                        <select class="form-control nivelC" id="nivelC">
                            <option value='Seleccionar'>Seleccionar</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name-2">Taxonomía</label>
                        <select name='' class="form-control taxonomia" id="taxonomia">
                            <option value='Seleccionar'>Seleccionar</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name-2">Competencia *</label>
                        <textarea class="form-control" placeholder="descripcion competencia"
                                  id="competencia">{{$desComp}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="button" id="btnGuardar" value="Actualizar" class="btn btn-primary"/>
            </div>

        </div>

    </div>
@stop
@section('scripts')
    <script>
        var dificult = $('#dificult').val();
        var idTax = $('#idTax').val();
        var idNC = $('#idNC').val();
        var tok = $('token').val();
        $("#dificultad option[value=" + dificult + "]").attr("selected", true);
        cargarNC();
        cargarVerbo();

        function cargarNC() {

            $.ajax({
                type: "get",
                url: "{{ route('Docente.descripcion') }}",
                data: {
                    dificultad: dificult,
                    token: tok
                }, success: function (data) {
                    console.log('success');
                    console.log(data);
                    //console.log(data.length);
                    $('#nivelC').empty();
                    for (var i = 0; i < data.length; i++) {
                        $('#nivelC').append('<option value="' + data[i].id + '">' + data[i].descripcionNC + '</option>');

                    }
                    $("#nivelC option[value=" + idNC + "]").attr("selected", true);
                }
            });
        }

        function cargarVerbo() {
            $.ajax({
                type: "get",
                url: "{{ route('Docente.verboTaxonomia') }}",
                data: {
                    nivelC: idNC,
                    token: tok

                }, success: function (data) {
                    console.log('success');

                    console.log(data);

                    console.log(data.length);
                    $('#taxonomia').empty();
                    for (var i = 0; i < data.length; i++) {
                        $('#taxonomia').append('<option value="' + data[i].id + '">' + data[i].verbo + '</option>');
                    }
                    $("#taxonomia option[value=" + idTax + "]").attr("selected", true);

                }


            });
        }


        $('#dificultad').change(function () {
            if ($(this).val() != '') {

                var dificultad = $('#dificultad').val();
                var token = $('token').val();

                $.ajax({
                    type: "get",
                    url: "{{ route('Docente.descripcion') }}",
                    data: {
                        dificultad: dificultad,
                        token: token

                    }, success: function (data) {
                        console.log('success');

                        console.log(data);

                        //console.log(data.length);
                        $('#nivelC').empty();
                        for (var i = 0; i < data.length; i++) {
                            $('#nivelC').append('<option value="' + data[i].id + '">' + data[i].descripcionNC + '</option>');

                        }


                    }
                });

            }
        });

        //ajax para taxonomia bloom
        $('#nivelC').change(function () {
            if ($(this).val() != '') {
                console.log("hmm its change taxonomia");

                var idNivelC = $('#nivelC').val();
                var token = $('token').val();
                $.ajax({
                    type: "get",
                    url: "{{ route('Docente.verboTaxonomia') }}",
                    data: {
                        nivelC: idNivelC,
                        token: token

                    }, success: function (data) {
                        console.log('success');

                        console.log(data);

                        console.log(data.length);
                        $('#taxonomia').empty();
                        for (var i = 0; i < data.length; i++) {
                            $('#taxonomia').append('<option value="' + data[i].id + '">' + data[i].verbo + '</option>');

                        }


                    }


                });

            }
        });


        $('#btnGuardar').on('click', function () {

            var idhoras = $('#idHoras').val();
            var idComp = $('#idComp').val();
            var horaT = $('#horasT').val();
            var horaP = $('#horasP').val();
            var horaL = $('#horasL').val();
            var dasg = $('#idDasg').val();
            var tax = $('#taxonomia').val();
            var com = $('#competencia').val();
            var token = $('token').val();

            $.ajax({
                type: "post",
                url: "{{ route('Competencias.update') }}",
                data: {
                    horasP: horaP,
                    horasT: horaT,
                    horasL: horaL,
                    idhora: idhoras,
                    idtax: tax,
                    token: token,
                    idcomp: idComp,
                    competencias: com,

                }, success: function (msg) {
                    alert("Se ha realizado el POST con exito ");
                    location.href = '/Docente/competencias';
                }
            });
        });

    </script>


@stop
