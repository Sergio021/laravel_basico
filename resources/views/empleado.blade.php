<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Solo empleado</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/estilos.css') }}">
</head>
<body>
	<h1>Hola mundo.com</h1>
	<br>
	<p>Nombre del empleado {{$nombre}} trabajó {{$dias}} días</p>
	<span>Se le pagó se le pagó {{$nomina}}</span>

	@if($nombre == "lolo")
		<h1>Hola {{$nombre}} :3</h1>
		<br>
		<img src="{{ asset('fotos/adopcion_b1_mob.jpg'); }}" width="100" height="auto">
	@else
		<h1>Hola {{$nombre}}</h1>
		<br>
		<img src="{{ asset('fotos/adopcion_b3_mob.jpg'); }}" width="100" height="auto">
	@endif
	<br>
	<a href="{{route('salir')}}">Salir</a>


	
</body>
</html>