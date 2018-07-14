@extends('backpack::layout')

@section('header')
    <h1 class="content-header">
        <i class=""></i>Ingresar Contenido/
        @foreach($asignatura as $as)
            {{$as->as_nombre}}
        @endforeach
        <input type="hidden" value="{{$idA}}" id="idDasg"/>
        <input type="hidden" value="{{base64_encode($idS)}}" id="semana1"/>
        <input type="hidden" value="{{base64_encode($horasOcupadas)}}" id="hoursTaken"/>
        <input type="hidden" value="{{base64_encode($numCreditos)}}" id="credits"/>
    </h1>
@endsection

@section('content')

    @if(empty($contenidos) || $stateNew==true)
        <div class="page-content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <!-- form start -->
                        <div class="panel-body pbody">
                            <div id="navigation_holder">
                                <ul class="pager">
                                    @if(!empty($contenidos))
                                        <li class="previous"><a href="/semanas/semana1/{{base64_encode($idA)}}/{{base64_encode($idS)}}/{{$index-1}}">&larr; Anterior</a></li>
                                        <span style="font-size:1.3em;font-weight:bold; text-align: center;">Semana {{$idS}}</span>
                                        <li class="next"><a href="/semanas/semana1/{{base64_encode($idA)}}/{{base64_encode($idS)}}/{{$index}}">Siguiente &rarr;</a></li>
                                    @else
                                        <li class="previous"><a href="#">&larr; Anterior</a></li>
                                        <span style="font-size:1.3em;font-weight:bold; text-align: center;">Semana {{$idS}}</span>
                                        <li class="next"><a href="#">Siguiente &rarr;</a></li>
                                    @endif

                                </ul>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>Contenido</label>
                                    <input required type="text" style="width:550px;" class="form-control required"
                                           placeholder="Ingrese Contenido" id="Contenido1">
                                    <input type="hidden" value="{{csrf_token()}}" id="token"/>
                                </div>
                                <div class="col-md-2">
                                    <button id="masfilas" class="btn btn-sm btn-primary">Agregar Temas
                                        <span style="font-size:16px; font-weight:bold;">+ </span>
                                    </button>
                                </div>
                            </div>
                            <form method="post" action="">

                                <table class="table table-striped database-tables" id="mytable">
                                    <thead>
                                    <tr>
                                        <th >Temas</th>
                                        <th >Horas Asignadas</th>
                                        <th >% Aprobación</th>
                                        <th >Prioridad</th>
                                        <th >Acciones</th>

                                    </tr>

                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                        </div>
                        <div id="buttons_holder">

                            <a title="definirContenido"
                               class="btn btn-sm btn-primary" id=""><span>Actualizar</span></a>
                            <a title="definirContenido"
                               class="btn btn-sm btn-primary" id="ok"><span>Guardar</span></a>
                        </div>

                        </form>
                    </div>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>


                </div>
            </div>
        </div>
        </div>
    @else
        <div class="page-content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <!-- form start -->
                        <div class="panel-body pbody">
                            <div id="navigation_holder">
                                <ul class="pager">

                                    <li class="previous"><a href="/semanas/semana1/{{base64_encode($idA)}}/{{base64_encode($idS)}}/{{$index-1}}">&larr; Anterior</a></li>
                                    <span style="font-size:1.3em;font-weight:bold; text-align: center;">Semana {{$idS}}</span>
                                    <li class="next"><a href="/semanas/semana1/{{base64_encode($idA)}}/{{base64_encode($idS)}}/{{$index+1}}">Siguiente &rarr;</a></li>
                                </ul>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>Contenido</label>
                                    <input required type="text" style="width:550px;" class="form-control required"
                                           placeholder="Ingrese Contenido" id="Contenido1" readonly  value="{{$contenidos[$index]->descripcion}}">

                                    <input type="hidden" value="{{csrf_token()}}" id="token"/>
                                </div>
                                <div class="col-md-2">
                                    <button id="masfilas" class="btn btn-sm btn-primary">Agregar Temas
                                        <span style="font-size:16px; font-weight:bold;">+ </span>
                                    </button>
                                </div>
                            </div>
                            <form method="post" action="">

                                <table class="table table-striped database-tables" id="mytable">
                                    <thead>
                                    <tr>
                                        <th >Temas</th>
                                        <th >Horas Asignadas</th>
                                        <th >% Aprobación</th>
                                        <th >Prioridad</th>
                                        <th >Acciones</th>

                                    </tr>
                                    @foreach($contenidos as $content)
                                        @if($content->id==$indexs[$index])
                                            <tr>
                                                <td>{{$content->tema}}</td>
                                                <td>{{$content->horas_asignadas}}</td>
                                                <td>{{$content->porcentaje_aprobacion}}</td>
                                                <td>{{$content->prioridad}}</td>
                                                <td>
                                                    <a href="" title="definirContenido"
                                                       class="btn btn-sm btn-primary pull-right edit" id="1"><i
                                                                class="voyager-edit"></i> <span>Ver Semanas</span></a>

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                        </div>
                        <div id="buttons_holder">

                            <a title="definirContenido"
                               class="btn btn-sm btn-primary" id=""><span>Actualizar</span></a>
                            <a title="definirContenido"
                               class="btn btn-sm btn-primary" id="ok"><span>Guardar</span></a>
                        </div>

                        </form>
                    </div>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>


                </div>
            </div>
        </div>
        </div>
    @endif

@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $("#masfilas").click(function () {

                $("#mytable").append('<tr><td><input type="text" class="data"/></td>' +
                    '<td> <input class="data" type="number"/></td>' +
                    '<td> <input class="data" type="number"/></td>' +
                    '<td> <select class="data">\n' +
                    '  <option value="volvo" selected>Seleccionar</option>\n' +
                    '<option value="1">1</option>\n' +
                    '  <option value="2">2</option>\n' +
                    '  <option value="3">3</option>\n' +
                    '  <option value="4">4</option>\n' +
                    '  <option value="5">5</option>\n' +
                    '</select></td>' +
                    '<td><a href="/Repositorio/ingresarOA" class="btn btn-sm btn-primary pull-right edit" "><i class="voyager-edit"></i></a>' +
                    '<a href="#" class="btn btn-sm btn-danger pull-right delete"><i class="voyager-trash"></i></a></td></tr>');
                $('.delete').off().click(function (e) {
                    $(this).parent('td').parent('tr').remove();

                });
            });
        });


        $("#ok").click(function () {

            var contenido = $('#Contenido1').val();
            var idAsignatura = $('#idDasg').val();
            var semana = atob($('#semana1').val());
            var hoursTaken = Number(atob($('#hoursTaken').val()));
            var credits = Number(atob($('#credits').val()));
            var token = $('token').val();
            var inputs = document.getElementsByClassName('data');
            var lista = new Array();
            var vectorAsignado = [];
            var data = [];
            for (var i = 0; i < inputs.length; i++) {
                data.push(inputs[i].value);
            }
            for (var i = 0; i < inputs.length; i = i + 4) {
                var data1 = data.slice(i, i + 4);
                lista.push(data1);
            }
            var horas=0;
            for (var index in lista) {
                var horas= horas+Number(lista[index][1]);
                var dataTemp = {
                    tema: lista[index][0],
                    hasig: lista[index][1],
                    papro: lista[index][2],
                    prioridad: lista[index][3]
                };
                vectorAsignado.push(dataTemp);
            }
            var auxHours=hoursTaken+horas;
            if(auxHours>credits){
                alert("No puede ingresar: "+horas+" horas para esta semana, le quedan disponibles : "+(credits-hoursTaken)+" horas para el resto de la semana");
            }else{

                var DataCode = JSON.stringify(vectorAsignado);
                $.ajax({
                    type:"post",
                    url:"{{ route('Docente.contenidoSave')  }}",
                    data:{
                        semana:semana,
                        idAsignatura:idAsignatura,
                        contenidoS1:contenido,
                        token:token,
                        listaTemas:DataCode,
                    },success: function (msg) {
                        alert("Se ha realizado el POST con exito ");
                        location.reload();

                    }


                });
            }




        });


    </script>


@endsection





