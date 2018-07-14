@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-group"></i>Editar Asignatura
    </h1>
@stop
@section('content')
    <input type="hidden" value="{{csrf_token()}}" id="token"/>
    <input type="hidden" value="{{$Asignatura['as_id'] }}" id="idAsig"/>
    <input type="hidden" value="{{$Asignatura['as_nivel'] }}" id="idNivel"/>
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <label for="name">Asignatura</label>
                <input required type="text" class="form-control required" value="{{$Asignatura['as_nombre'] }}"
                       placeholder="Ingrese Nombre" id="NombreAsig">
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
                <input required type="text" class="form-control required" placeholder="Nº Creditos"
                       value="{{$Asignatura['as_num_credito']}}" id="CreditosAsig">
            </div>
            <div class="form-group col-md-12">
                <label for="name">Estado</label>
                <select name='idnivel' class="form-control" id='estadoAsig'>
                    <option placeholder="seleccionar" value='Seleccionar'>Seleccionar</option>
                    <option value='1'>Inactivo</option>
                    <option value='2'>Suspendido</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" id='btnGuardar' type="submit">Guardar</button>
                <button class="btn btn-danger" id="btnCancelar" type="reset">Cancelar</button>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        var nivel = $('#idNivel').val();

        $("#nivelAsig option[value=" + nivel + "]").attr("selected", true);

        $('#btnCancelar').on('click', function () {
            location.href = '{{route('Administrador.indexAsignatura')}}';
        });

        $('#btnGuardar').click(function (e) {
            var NombreAsignatura = $('#NombreAsig').val();
            var NivelAsignatura = $('#nivelAsig').val();
            var CreditoAsignatura = $('#CreditosAsig').val();
            var idAsignatura = $('#idAsig').val();
            var EstadoAsignatura=$('#estadoAsig').val();
            var token = $('token').val();

            $.ajax({
                type: "post",
                url: "{{route('Administrador.updateAsignatura')}}",
                data: {
                    NombreAsignatura: NombreAsignatura,
                    NivelAsignatura: NivelAsignatura,
                    CreditoAsignatura: CreditoAsignatura,
                    idAsignatura: idAsignatura,
                    EstadoAsignatura:EstadoAsignatura,
                    token: token
                }, success: function (msg) {
                    alert("Se ha actualizado la materia");
                    location.href = '{{route('Administrador.indexAsignatura')}}';
                }
            });

        });


    </script>}


@stop

