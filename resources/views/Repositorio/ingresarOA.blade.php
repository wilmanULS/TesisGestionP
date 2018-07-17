@extends('backpack::layout')
@section('header')
    <h1 class="content-header">
        <i class=""></i>
        Ingresar Objetos Aprendizaje

    </h1>
@endsection

@section('content')
    <div class="panel panel-bordered">
        <div class="row" style="background-color: #f9f9f9;">
            <form action="uploading" method="post" enctype="multipart/form-data">
            <div class="panel-body col-sm-5" style="background-color: white; box-shadow: 3px 3px 5px #999; margin: 30px;">

                <label for="name">Descripción General</label>
                <br>
                <input type="hidden" value="{{csrf_token()}}" id="token"/>
                <input type="hidden" value="{{$idTema}}" id="idTema"/>
                <div class="form-group col-md-8">
                    <label for="name">Título *</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="titulo">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Descripcion *</label>
                    <textarea class="form-control" placeholder="Ingrese una descripción"
                              id="descripcionG"></textarea>
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Autor1 *</label>
                    <input required type="text" class="form-control required"
                           placeholder="Autor" id="autor1">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Autor 2(Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Autor" id="autor2">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Autor 3 (Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Autor" id="autor3">
                </div>


            </div>
            <div class="panel-body col-md-5" style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

                <label for="name">Palabras Clave</label>
                <br>
                <br>

                <div class="form-group col-md-8">
                    <label for="name">keyword 1 *</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="keyword1">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">keyword 2 (Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="keyword2">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">keyword 3 (Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="keyword3">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">keyword 4 (Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="keyword4">
                </div>
                <div class="form-group col-md-8">
                    <label for="name">keyword 5 (Opcional)</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="keyword5">
                </div>
            </div>

            <div class="panel-body col-md-5" style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

                <label for="name">Descripción Técnica</label>
                <br>
                <br>
                <div class="form-group col-md-8">
                    <label for="name">Tamaño *</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="tamaño">
                </div>

                <div class="form-group col-md-8">
                    <label for="name">Descripción (Opcional) *</label>
                    <input required type="text" class="form-control required"
                           placeholder="Ingrese Título" id="descripcionT">
                </div>
                <div class="form-gropu col-md-8">
                    <label for="name">Dificultad</label>
                    <select class="form-control" id="dificultad">
                        <option value='Seleccionar'>Seleccionar</option>
                        @foreach($dificultad as $dif)
                            <option value='{{$dif->id}}'>{{$dif->descripcion}}</option>

                        @endforeach
                    </select>

                </div>
                <div class="form-gropu col-md-8">
                    <label for="name">Idioma</label>
                    <select class="form-control" id="idioma">
                        <option value='Seleccionar'>Seleccionar</option>
                        @foreach($idioma as $idi)
                            <option value='{{$idi->id}}'>{{$idi->descripcion}}</option>

                        @endforeach
                    </select>

                </div>

                <div class="form-gropu col-md-8">
                    <label for="name">Tipo de recurso educativo</label>
                    <select class="form-control" id="recursoEdu">
                        <option value='Seleccionar'>Seleccionar</option>
                        @foreach($recursoEdu as $recurso)
                            <option value='{{$recurso->id}}'>{{$recurso->descripcion}}</option>

                        @endforeach
                    </select>

                </div>
                <div class="form-gropu col-md-8">
                    <label for="name">Formato</label>
                    <select class="form-control" id="formato">
                        <option value='Seleccionar'>Seleccionar</option>
                        @foreach($formato as $form)
                            <option value='{{$form->id}}'>{{$form->descripcion}}</option>

                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-8">
                    <label for="name">Evaluación Docente </label>
                    <select class="form-control"id="evaluacion"/>
                    <option selected>Seleccionar</option>

                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    </select>

                </div>

                <div hidden class="form-group col-md-8">
                    <label for="name" >Estado </label>
                    <input id="estadophp" class="form-control required" type="text" value="Activo" readonly/>
                </div>


            </div>

            <div class="panel-body col-md-5" style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

                <label for="name">Cargar Objeto Aprendizaje</label>
                <br>
                <br>
                <div class="form-group col-md-9">
                    <label for="name" >Seleccione Archivo 1</label>
                    <input type="file" class="form-control" id="url1" >
                </div>
                <div class="form-group col-md-9">
                    <label for="name" >Seleccione Archivo 2</label>
                    <input type="file" class="form-control" name="url2" >
                </div>
                <div class="form-group col-md-9">
                    <label for="name" >Seleccione Archivo 3</label>
                    <input type="file" class="form-control" name="url3" >
                </div>
                <div class="form-group col-md-9">
                    <label for="name" >Seleccione Archivo 4</label>
                    <input type="file" class="form-control" name="url4" >
                </div>
                <div class="form-group col-md-9">
                    <label for="name" >Seleccione 5</label>
                    <input type="file" class="form-control" name="url5" >
                </div>

                <div class="form-group col-md-9">
                    <input type="button" id="btAdd" value="Guardar" class="btn btn-primary"/>
                    <input type="button" id="btRemove" value="Cancelar" class="btn btn-danger"/>
                </div>
            </div>
        </form>
        </div>
    </div>

@endsection
@section('scripts')
<script>

    //guardar OA
    $("#btAdd").click(function () {


        var idTema=$('#idTema').val();
        var titulo = $('#titulo').val();
        var descripcion = $('#descripcionG').val();
        var autor1 = $('#autor1').val();
        var autor2 = $('#autor2').val();
        var autor3 = $('#autor3').val();
        var keyword1 = $('#keyword1').val();
        var keyword2 = $('#keyword2').val();
        var keyword3 = $('#keyword3').val();
        var keyword4 = $('#keyword4').val();
        var keyword5 = $('#keyword5').val();
        var tamanio = $('#tamaño').val();
        var descripcionT = $('#descripcionT').val();
        var dificultad = $('#dificultad').val();
        var idioma = $('#idioma').val();
        var tipoRecurso = $('#recursoEdu').val();
        var formato = $('#formato').val();
        var evalDocente = $('#evaluacion').val();
        var url1 = $('#url1');
        var archivo=url1[0].files;

        $.ajax({
            type:"post",
            url:"{{ route('Repositorio.saveOA')  }}",
            data:{
                idTema:idTema,
                 titulo:titulo,
         descripcion:descripcion,
         autor1: autor1,
         autor2: autor2,
         autor3: autor3,
         keyword1:keyword1,
         keyword2: keyword2,
         keyword3: keyword3,
         keyword4: keyword4,
         keyword5: keyword5,
         tamanio:  tamanio,
         descripcionT:descripcionT,
         dificultad:dificultad,
         idioma:idioma,
         tipoRecurso:tipoRecurso,
         formato:formato,
         evalDocente:evalDocente,
         url1:url1,

            },success: function (msg) {
                alert("Se ha realizado el POST con exito ");

            }


        });



    });






</script>

@endsection
