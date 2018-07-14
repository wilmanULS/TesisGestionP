@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-group"></i>Crear Asignatura
    </h1>
@stop
@section('content')
    <input type="hidden" value="{{csrf_token()}}" id="token"/>
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <label for="name">Asignatura</label>
                <input required type="text" class="form-control required" placeholder="Ingrese Nombre" id="NombreAsig">
            </div>
            <div class="form-group col-md-12">
                <label for="name">Nivel</label>
                <select name='idnivel' class="form-control" id='nivelAsig'>
                    <option placeholder="seleccionar" value='Seleccionar'>Seleccionar</option>
                    @foreach($NivelAsignatura as $valor)
                        <option value='{{$valor->as_nivel}}'>{{$valor->as_nivel}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="name">Nº de Creditos</label>
                <input required type="text" class="form-control required" placeholder="Nº Creditos" id="CreditosAsig">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" id='btnGuardar' type="submit">Guardar</button>
                <button class="btn btn-danger" id="cancelar" type="reset">Cancelar</button>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $('#btnGuardar').click(function (e) {

            e.preventDefault();
            var NombreAsignatura = $('#NombreAsig').val();
            var NivelAsignatura = $('#nivelAsig').val();
            var CreditoAsignatura = $('#CreditosAsig').val();

            var token = $('token').val();

            $.ajax({
                type: "post",
                url: "{{route('Administrador.saveAsignatura')}}",
                data: {
                    NombreAsignatura: NombreAsignatura,
                    NivelAsignatura: NivelAsignatura,
                    CreditoAsignatura: CreditoAsignatura,
                    token: token
                }, success: function (msg) {
                    if (msg == true) {
                        alert("Se ha creado la Asignatura");
                        location.href = '{{route('Administrador.indexAsignatura')}}';
                    } else {
                        alert("La Asignatura ya existe");
                    }

                }
            });

        });


    </script>}


@stop

