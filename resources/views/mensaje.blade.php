@extends('vistaBootstrap')

@section('contenido')

<div class="container">
	<h1>{{$proceso}}</h1>
	<br>
	<div class="alert alert-success">
		{{$mensaje}}
	</div>
</div>

@stop