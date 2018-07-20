@extends('backpack::layout')
@section('page_header')
    <h1 class="content-header">
        <i class=""></i>
        Ingresar Objetos Aprendizaje

    </h1>
@endsection

@section('content')
    <div class="panel panel-bordered">
        <div class="row" style="background-color: #f9f9f9;">
            <form action="uploading" method="post" enctype="multipart/form-data">
                <div class="panel-body col-sm-5"
                     style="background-color: white; box-shadow: 3px 3px 5px #999; margin: 30px;">

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
                <div class="panel-body col-md-5"
                     style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

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

                <div class="panel-body col-md-5"
                     style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

                    <label for="name">Descripción Técnica</label>
                    <br>
                    <br>
                    <div class="form-group col-md-8">
                        <label for="name">Tamaño *</label>
                        <input required type="number" class="form-control required"
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
                        <select class="form-control" id="evaluacion"/>
                        <option selected>Seleccionar</option>

                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        </select>

                    </div>

                    <div hidden class="form-group col-md-8">
                        <label for="name">Estado </label>
                        <input id="estadophp" class="form-control required" type="text" value="Activo" readonly/>
                    </div>


                </div>

                <div class="panel-body col-md-5"
                     style="background-color: white;box-shadow: 3px 3px 5px #999;margin: 30px;">

                    <label for="name">Cargar Objeto Aprendizaje</label>
                    <br>
                    <br>
                    <div id="datafiles">

                        <div class="form-group col-md-9">
                            <label for="name">Seleccione Archivo 1</label>
                            <input type="file" class="form-control" id="url">
                        </div>
                        <div>
                            <button style="margin-top: 30px;" id="btnAddF"><span class="fa fa-plus-square"></span>
                            </button>
                            <button id="btnDeleteF"><span class="fa fa-minus-square"></span></button>
                        </div>

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
        var CP = 1;
        var container = $(document.getElementById('datafiles'));


        $('#btnAddF').click(function () {
            if (CP < 10) {

                CP = CP + 1;

                // Añadir caja de texto.
                $(container).append(' <div id="CP' + CP + '" class="form-group col-md-9">\n' +
                    '                        <label for="name" id>Seleccione Archivo ' + CP + '</label>\n' +
                    '                        <input type="file" class="form-control" id="url' + CP + '" >\n' +
                    '                    </div>');

                $('#main').after(container);
                addEvent(CP);
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                alert('Limite alcanzado');
                $('#btnAddF').attr('class', 'bt-disable');
                $('#btnAddF').attr('disabled', 'disabled');

            }
        });

        function addEvent(id) {
            $('#url' + id + '').unbind();
        }

        $('#btnDeleteF').click(function () {   // Elimina un elemento por click
            if (CP != 0) {
                $('#CP' + CP).remove();
                CP = CP - 1;
            }
            if (CP == 0) {
                alert('Minimo una Competencia')
            }

        });

        function AgregarNuevos() {
            $('#url2').unbind();
            $('#url3').unbind();
            $('#url4').unbind();
            $('#url5').unbind();
            $('#url6').unbind();
            $('#url7').unbind();
            $('#url8').unbind();
            $('#url9').unbind();
            $('#url10').unbind();
        }

        //guardar OA
        $("#btAdd").click(function (event) {

            var idTema = $('#idTema').val();
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
            var file = $('#url').val();
            var paqueteDeDatos = new FormData();

            AgregarNuevos();

            if (validarCampos(titulo, descripcion, autor1, keyword1, tamanio, dificultad, idioma, tipoRecurso, formato, evalDocente, file)) {

                paqueteDeDatos.append('file1', $('#url')[0].files[0]);

                for (let i = 2; i <= 10; i++) {
                    let valor = $('#url' + i + '').val();
                    if (valor != "" && valor != undefined) {
                        paqueteDeDatos.append('file' + i + '', $('#url' + i + '')[0].files[0]);
                    }
                }

                //datos
                paqueteDeDatos.append('idTema', idTema);
                paqueteDeDatos.append('titulo', titulo);
                paqueteDeDatos.append('descripcion', descripcion);
                paqueteDeDatos.append('autor1', autor1);
                paqueteDeDatos.append('autor2', autor2);
                paqueteDeDatos.append('autor3', autor3);
                paqueteDeDatos.append('keyword1', keyword1);
                paqueteDeDatos.append('keyword2', keyword2);
                paqueteDeDatos.append('keyword3', keyword3);
                paqueteDeDatos.append('keyword4', keyword4);
                paqueteDeDatos.append('keyword5', keyword5);
                paqueteDeDatos.append('tamanio', tamanio);
                paqueteDeDatos.append('descripcionT', descripcionT);
                paqueteDeDatos.append('dificultad', dificultad);
                paqueteDeDatos.append('idioma', idioma);
                paqueteDeDatos.append('tipoRecurso', tipoRecurso);
                paqueteDeDatos.append('formato', formato);
                paqueteDeDatos.append('evalDocente', evalDocente);

                $.ajax({
                    type: "post",
                    url: " {{route('Repositorio.saveOA') }}",
                    contentType: false,
                    data: paqueteDeDatos, // Al atributo data se le asigna el objeto FormData.
                    processData: false,
                    cache: false
                    , success: function (msg) {
                        if (confirm("Se ha agregado el OA \n Desea agregar otro OA")) {
                            location.reload();
                        } else {
                            location.href = '/Docente/Indextemas/ingresarOA';
                        }

                    }
                });
            }

//files

        });

        function validarCampos(titulo, descripcionG, autor1, keyword1, tamanio, dificultad, idioma, trecurso, formato, Edocente, file) {

            if (titulo == "") {
                alert('Necesita un titulo');
                return false;
            } else {
                if (descripcionG == "") {
                    alert('Necesita una descripcion');
                    return false;
                } else {
                    if (autor1 == "") {
                        alert('Minimo un autor');
                        return false;
                    } else {
                        if (keyword1 == "") {
                            alert('Necesita una palabra clave');
                            return false;
                        } else {
                            if (tamanio == "") {
                                alert('Ingreso un tamaño');
                                return false;
                            } else {
                                if (dificultad == "Seleccionar") {
                                    alert('Ingreso una dificultad');
                                    return false;
                                } else {
                                    if (idioma == "Seleccionar") {
                                        alert('Elija un idioma');
                                        return false;
                                    } else {
                                        if (trecurso == "Seleccionar") {
                                            alert('Elija un recurso');
                                            return false;
                                        } else {
                                            if (formato == "Seleccionar") {
                                                alert('Elija un formato');
                                                return false;
                                            } else {
                                                if (Edocente == "Seleccionar") {
                                                    alert('Elija un calificacion para el OA');
                                                    return false;
                                                } else {
                                                    if (file == "") {
                                                        alert("Minimo un archivo");
                                                        return false;
                                                    } else {
                                                        return true;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


    </script>

@endsection
