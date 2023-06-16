@extends('vistaBootstrap')

@section('contenido')

<div class="container">
	<h1>Reporte de empleado</h1>
	<br>
	<a href="{{ route('altaEmpleado'); }}" type="button" class="btn btn-light">Registrar nuevo</a>
	<br>
	<br>
	@if(Session::has('mensaje'))
	<div class="alert alert-success">
		{{Session::get('mensaje')}}
	</div>
	@endif
	<table class="table my-3">
	  <thead>
	    <tr>
	      <th scope="col">Id</th>
	      <th scope="col">Nombre</th>
	      <th scope="col">Apellido</th>
	      <th scope="col">Departamento</th>
	      <th scope="col">Correo</th>
	      <th scope="col">Foto</th>
	      <th scope="col">Operaciones</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($consulta as $dato)
	    <tr>
	      <td>{{$dato->ide}}</td>
	      <td>{{$dato->nombre}}</td>
	      <td>{{$dato->apellido}}</td>
	      <td>{{$dato->depa}}</td>
	      <td>{{$dato->email}}</td>
	      <td> <img src="{{ asset('archivos/'.$dato->img)}}" width="50" height="auto"></td>
	      <td>
	      	<a href="{{ route('modificaEmpleado', ['ide'=>$dato->ide]); }}" class="btn btn-warning">Modificar</a>
	      	@if($sessionTipo == "admin")
		      	@if($dato->deleted_at)
		      	<a href="{{ route('activaEmpleado',['ide'=>$dato->ide]); }}" class="btn btn-info">Activar</a>
		      	<a href="{{ route('eliminarEmpleado',['ide'=>$dato->ide]); }}" class="btn btn-danger">Eliminar</a>
		      	@else
				<a href="{{ route('desactivaEmpleado',['ide'=>$dato->ide]); }}" class="btn btn-info">Desactivar</a>

		      	@endif
		    @endif
	      </td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>

@stop