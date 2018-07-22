@extends('backpack::layout')
@section('header')
    <h1 class="content-header">
        <i class=""></i>
        @foreach($asignatura as $as)
            {{$as->as_nombre}}
        @endforeach
        <input type="hidden" value="{{$idA}}" id="idDasg"/>
    </h1>
@endsection
@section('content')
    <div class="panel panel-bordered">
        <div class="panel-body">


                <h3>Registrar Horas</h3>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="name">Horas Teóricas *</label>
                        <input required type="number" class="form-control required"
                               placeholder="N° Total de Horas" id="horasT">
                    </div>
                    <div class="form-group col-md-4">

                        <label for="name">Horas Práctica *</label>
                        <input required type="number" class="form-control required"
                               placeholder="N° Total de Horas" id="horasP">
                    </div>
                    <div class="form-group col-md-4">

                        <label for="name">Horas Laboratorio *</label>
                        <input required type="number" class="form-control required"
                               placeholder="N° Total de Horas" id="horasL">

                        <input type="hidden" value="{{csrf_token()}}" id="token"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-bordered">
            <div class="panel-body">
                <h3>Definir Competencias</h3>
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
                                      id="competencia"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <input type="button" id="btAdd" value="Añadir Competencia" class="fa fa-plus"/>
                    <input type="button" id="btRemove" value="Eliminar Competencia" class="fa fa-trash"/>
                </div>
                <br>
                <br>
                <div class="row">
                    <input type="button" id="btnGuardar" value="Guardar" class="btn btn-primary"/>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('scripts')

<script>
    // ajax traer nivel cognoscitivo
    $(document).ready(function () {
        var CP = 0;
        //añadido dnamico

// Crear un elemento div añadiendo estilos CSS
        var container = $(document.getElementById('competencias'));

        $('#btAdd').click(function () {
            if (CP < 4) {

                CP = CP + 1;

                // Añadir caja de texto.
                $(container).append('<div class=row id=CP' + CP + '>  <div class="form-group col-md-4">\n' +
                    '                            <label for="name-2">Dificultad</label>\n' +
                    '                            <select class="form-control dificultad" id="dificultad' + CP + '">\n' +
                    '                                <option value=\'Seleccionar\'>Seleccionar</option>\n' +
                    '                                @foreach($dificultad as $dif)\n' +
                    '                                    <option value=\'{{$dif->dificultad}}\'>{{$dif->dificultad}}</option>\n' +
                    '\n' +
                    '                                @endforeach\n' +
                    '                            </select>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="name-2">Nivel Cognoscitivo</label>\n' +
                    '                            <select class="form-control nivelC" id="nivelC' + CP + '">\n' +
                    '                                <option value=\'Seleccionar\'>Seleccionar</option>\n' +
                    '                            </select>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="name-2">Taxonomía</label>\n' +
                    '                            <select name=\'\' class="form-control taxonomia" id="taxonomia' + CP + '">\n' +
                    '                                <option value=\'Seleccionar\'>Seleccionar</option>\n' +
                    '                            </select>\n' +
                    '                        </div>\n' +
                    '\n' +
                    '                        <div class="form-group col-md-4">\n' +
                    '                            <label for="name-2">Competencia *</label>\n' +
                    '                            <textarea class="form-control" placeholder="descripcion competencia"\n' +
                    '                                      id="competencia' + CP + '"></textarea>\n' +
                    '                        </div>  </div>');


                $('#main').after(container);
                addEvent(CP);
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                alert('Limite alcanzado');
                $('#btAdd').attr('class', 'bt-disable');
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function () {   // Elimina un elemento por click
            if (CP != 0) {
                $('#CP' + CP).remove();
                CP = CP - 1;
            }
            if (CP == 0) {
                alert('Minimo una Competencia')
            }

        });


        //
        $('#dificultad').change(function () {
            if ($(this).val() != '') {
                console.log("hmm its change");

                var dificultad = $('#dificultad').val();
                var token = $('#token').val();

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
                var token = $('#token').val();
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

//nombre
        function getNombre() {

            $.ajax({
                type: "get",
                url: "{{ route('Materia.descripcion') }}",
                data: {
                    dificultad: dificultad,
                    token: token

                }, success: function (data) {
                    console.log('success');

                    console.log(data);

                }
            });
        }


//n1
        function addEvent(id) {

            $('#dificultad' + id + '').unbind();
            $('#nivelC1' + id + '').unbind();
            $('#taxonomia' + id + '').unbind();

            $('#dificultad' + id + '').change(function () {
                if ($(this).val() != '') {
                    console.log("hmm its change");

                    var dificultad = $('#dificultad' + id + '').val();
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
                            $('#nivelC' + id + '').empty();
                            for (var i = 0; i < data.length; i++) {
                                $('#nivelC' + id + '').append('<option value="' + data[i].id + '">' + data[i].descripcionNC + '</option>');
                            }
                        }
                    });
                }
            });

            //ajax para taxonomia bloom
            $('#nivelC' + id + '').change(function () {
                if ($(this).val() != '') {
                    console.log("hmm its change taxonomia");

                    var idNivelC = $('#nivelC' + id + '').val();
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
                            $('#taxonomia' + id + '').empty();
                            for (var i = 0; i < data.length; i++) {
                                $('#taxonomia' + id + '').append('<option value="' + data[i].id + '">' + data[i].verbo + '</option>');

                            }
                        }
                    });
                }
            });
        }

        //

        //submit form
        $('#btnGuardar').on('click', function () {

            var horaT = $('#horasT').val();
            var horaP = $('#horasP').val();
            var horaL = $('#horasL').val();
            var dasg = $('#idDasg').val();
            var tax = $('#taxonomia').val();
            var com = $('#competencia').val();

            $('#taxonomia1').unbind();
            $('#taxonomia2').unbind();
            $('#taxonomia3').unbind();
            $('#taxonomia4').unbind();
            $('#competencia1').unbind();
            $('#competencia2').unbind();
            $('#competencia3').unbind();
            $('#competencia4').unbind();
            var tax1 = "";
            var tax2 = "";
            var tax3 = "";
            var tax4 = "";
            var com1 = "";
            var com2 = "";
            var com3 = "";
            var com4 = "";

            if ($('#taxonomia1').val() != undefined) {
                tax1 = $('#taxonomia1').val();
            }
            if ($('#taxonomia2').val() != undefined) {
                tax2 = $('#taxonomia2').val();
            }
            if ($('#taxonomia3').val() != undefined) {
                tax3 = $('#taxonomia3').val();
            }
            if ($('#taxonomia4').val() != undefined) {
                tax4 = $('#taxonomia4').val();
            }


            if ($('#competencia1').val() != undefined) {
                com1 = $('#competencia1').val();
            }
            if ($('#competencia2').val() != undefined) {
                com2 = $('#competencia2').val();
            }
            if ($('#taxonomia3').val() != undefined) {
                com3 = $('#competencia3').val();
            }
            if ($('#competencia4').val() != undefined) {
                com4 = $('#competencia4').val();
            }


            var compentenciasV = {};
            compentenciasV = {taxo:[tax,tax1,tax2,tax3,tax4],comp:[com,com1,com2,com3,com4]}
            var Comp = JSON.stringify(compentenciasV)
            var token = $('token').val();

            $.ajax({
                type: "post",
                url: "{{ route('Competencias.save') }}",
                data: {
                    horasP: horaP,
                    horasT: horaT,
                    horasL: horaL,
                    idDasg: dasg,
                    token: token,
                    competencias: Comp,

                }, success: function (data) {
                var val=JSON.parse(data);
                if(val.mgs==="exceso")
                {
                    alert("Solo puede agregar"+val.valor+" competencia (Elimine algunas)");
                }else {
                    alert("Se ha realizado el POST con exito ");//falta el preguntar

                    location.href = '/Docente/Indextemas/ingresarOA';
                }

            }
            });

        });
        //
    });
</script>loca
@endsection

