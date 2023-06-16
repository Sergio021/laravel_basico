@extends('vistaBootstrap')

@section('contenido')

<div class="container">
	<h1>Iniciar sesión</h1>
	<hr>
	<form action="{{ route('autenticar') }}" method="POST">
		{{csrf_field()}}
		<div class="mb-3">
			<label for="usuario" class="form-label">usuario</label>
			<input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="emailHelp">
			@if($errors->first('usuario'))
	            <p class="text-danger">{{$errors->first('usuario')}}</p>
	        @endif
		</div>
		<div class="mb-3">
			<label for="pass" class="form-label">Password</label>
			<input type="password" class="form-control" id="pass" name="pass">
			@if($errors->first('pass'))
	            <p class="text-danger">{{$errors->first('pass')}}</p>
	        @endif
		</div>
		<button type="submit" class="btn btn-primary">Iniciar sesión</button>
	</form>

	@if(Session::has('mensaje'))
	<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
		<strong>Error! </strong>{{Session::get('mensaje')}}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	@endif

</div>

@stop