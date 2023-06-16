<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/ruta1', function () {
    return "hola mundo";
});

Route::get('/areaRectangulo', function () {
    $base = 4;
    $altura =10;
    $area = $base * $altura;
    return "El area del rectangulo es: ".$area." debido a la base ".$base." y altura ".$altura;
});


/*recibimos parametros*/
Route::get('/areaRectangulo2/{base}/{altura}', 
    function ($base, $altura) {
        $area = $base * $altura;
        return "El area del rectangulo es: ".$area." debido a la base recibida ".$base." y altura recibida ".$altura;
    }
);


/*podemos esperar parametros vacias
Route::get('/nomina/{dias}/{pago?}', 
    function ($dias, $pago=null) {
        if ($pago == null) {
            $pago=100;
            $nomina = $dias*$pago;
        }
        else{
            $nomina = $dias*$pago;
        }
        echo "Son: $nomina <br> debido al numero de dias ".$dias." <br> y el pago ".$pago;
    }
);*/


/*Puede redireccionar a una ruta*/
Route::get('/redireccion', function () {
    return redirect("ruta1");
});

Route::redirect("redireccionar2","ruta1");

Route::redirect("redireccionar3","/areaRectangulo2/4/7");

Route::get('/redireccion4/{base}/{altura}', function ($base, $altura) {
    return redirect("/areaRectangulo2/$base/$altura");
});


// Manda al controlador
Route::get('mensaje', [EmpleadosController::class,'mensaje']);

Route::get('controlPago', [EmpleadosController::class,'pago']);

Route::get('nomina/{dias}/{pago}', [EmpleadosController::class,'nomina']);


// Para la vista
Route::get('muestraSaludo/{nombre}/{dias}', [EmpleadosController::class,'saludo']);

Route::get('salir', [EmpleadosController::class,'salir'])->name('salir'); //rutas con nombre


//Para añadir bootstrap
    //Route::get('bootstrap', [EmpleadosController::class,'vb'])->name('vb');
    //-> si lo queremos de layout no es necesario declararlo en ruta

//Usando el layout
Route::get('altaEmpleado', [EmpleadosController::class,'altaEmpleado'])->name('altaEmpleado');
//Recibiendo datos
Route::post('guardarEmpleado', [EmpleadosController::class,'guardarEmpleado'])->name('guardarEmpleado');


/* Migraciones:
    creamos la migración para crear una base de datos
    php artisan make:migration departamentos -> se guardará en raiz/database/migrations/fecha_nombre

    Antes de correr la migración modificamos el archivo .env agregando la información de la base de datos; luego ir a config/database.php y tambien colocar las conexiones
*/


/* Modelos:
    Creamos el modelo con el comando php artisan make:model empleados
    Estos se guardarán en app/Models
    Posteriormente añadimos los modelos a nuestro controlador y creamos su ruta
*/
Route::get('eloquent', [EmpleadosController::class,'eloquent'])->name('eloquent');

/* Soft deleted:
    Es una manera de indicar que un registro esta activo a partir de fechas, por lo que debemos agregar el campo deteled_at en la tabla
    Ver en el modelo de empleados.
*/

// Mostrar datos
Route::get('reporteEmpleados', [EmpleadosController::class,'reporteEmpleados'])->name('reporteEmpleados');

//eliminar

Route::get('desactivaEmpleado/{ide}', [EmpleadosController::class,'desactivaEmpleado'])->name('desactivaEmpleado');

Route::get('activaEmpleado/{ide}', [EmpleadosController::class,'activaEmpleado'])->name('activaEmpleado');

Route::get('eliminarEmpleado/{ide}', [EmpleadosController::class,'eliminarEmpleado'])->name('eliminarEmpleado');

//Modificar
Route::get('modificaEmpleado/{ide}', [EmpleadosController::class,'modificaEmpleado'])->name('modificaEmpleado');
Route::post('guardaEmpleado', [EmpleadosController::class,'guardaEmpleado'])->name('guardaEmpleado');


/*  Session flash 
Muestra mensajes que se quedan guardados en una sesion de forma temporal
Revisar en el controlador
*/

/* Manejo de archivos

Se debe crear una carpeta en public
ir a config/filesystems.php para configurar la direccion en donde se guardarán los archivos
revisar en el alta y modificación de registros

*/

// ************ Login ***********

Route::get('login', [LoginController::class,'login'])->name('login');
Route::post('autenticar', [LoginController::class,'autenticar'])->name('autenticar');
Route::get('cerrarsesion',[LoginController::class,'cerrarSesion'])->name('cerrarsesion');
//en el la dirección config/session.php podemos configurar el tiempo de vida de la sesion en minutos y si deseamos que la sesión se destruya al cerrar el navegador