@extends('vistaBootstrap')

@section('contenido')

<div class="container">
<h1>Modificación de empleado</h1>
<hr>
<form action = "{{route('guardaEmpleado')}}" method = "POST" enctype="multipart form-data">
    {{csrf_field()}} <!-- Este es un token que es obligatorio-->
    <div class="well">
      <div class="form-group">
          <label for="dni">Clave empleado:</label>
          <input type="text" name="ide" id="ide" class="form-control" placeholder="Clave empleado" tabindex="5" value="{{ $consulta->ide; }}" readonly="readonly">
          <!-- Los errores del formulario los cachamos con el siguiente codigo
              Se puede personalizar el texto en lang/en/validation.php
           -->
          @if($errors->first('ide'))
            <p class="text-danger">{{$errors->first('ide')}}</p>
          @endif
      </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" tabindex="1" value="{{ $consulta->nombre }}">
                @if($errors->first('nombre'))
                  <p class="text-danger">{{$errors->first('nombre')}}</p>
                @endif
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" tabindex="2" value="{{ $consulta->apellido }}">
                    @if($errors->first('apellido'))
                      <p class="text-danger">{{$errors->first('apellido')}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" tabindex="4" value="{{ $consulta->email }}">
                    @if($errors->first('email'))
                      <p class="text-danger">{{$errors->first('email')}}</p>
                    @endif
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="celular">Celular:</label>
                    <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular" tabindex="3" value="{{ $consulta->celular }}">
                    @if($errors->first('celular'))
                      <p class="text-danger">{{$errors->first('celular')}}</p>
                    @endif
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <label for="dni">Sexo:</label>

                @if( $consulta->sexo == 'M' )
                    <div class="custom-control custom-radio">
                    <input type="radio" id="sexo1" name="sexo"  value = "M" class="custom-control-input" checked="">
                    <label class="custom-control-label" for="sexo1">Masculino</label>
                    </div>
                    <div class="custom-control custom-radio">
                    <input type="radio" id="sexo2" name="sexo" value = "F" class="custom-control-input">
                    <label class="custom-control-label" for="sexo2">Femenino</label>
                    </div>
                @else
                    <div class="custom-control custom-radio">
                    <input type="radio" id="sexo1" name="sexo"  value = "M" class="custom-control-input" checked="">
                    <label class="custom-control-label" for="sexo1">Masculino</label>
                    </div>
                    <div class="custom-control custom-radio">
                    <input type="radio" id="sexo2" name="sexo" value = "F" class="custom-control-input" checked="">
                    <label class="custom-control-label" for="sexo2">Femenino</label>
                    </div>
                @endif


            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">

              <div class="form-group">
                <label for="dni">Departamento:</label>
                <select name = 'idd' class="custom-select">
                  <option selected value="{{ $consulta->idd }}">{{ $consulta->depa }}</option>
                  @foreach($departamentos as $departamento)
                    <option value="{{$departamento->idd}}">{{$departamento->nombre}}</option>
                  @endforeach
                </select>
              </div>

            </div>
        </div>
        <div class="form-group">
            <label for="dni">Descripción:</label>
            <textarea name="detalle" id="detalle" class="form-control" tabindex="5">
                {{ $consulta->descripcion }}
            </textarea>
        </div>
        <div class="mb-3">
          <label for="img" class="form-label">Foto de perfil</label>
          <img src="{{ asset('archivos/'.$consulta->img)}}" width="150" height="auto">
          <input class="form-control" type="file" id="img" name="img">
            @if($errors->first('img'))
                <p class="text-danger">{{$errors->first('img')}}</p>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-6">
              <input type="submit" value="Guardar" class="btn btn-danger btn-block btn-lg" tabindex="7" title="Guardar datos ingresados">
            </div>
        </div>
</form>


@stop