<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*Añadimos los modelos*/
use App\Models\departamentos;
use App\Models\empleados;

use Session; //para sesiones flash para eliminar las vistas mensajes

class EmpleadosController extends Controller
{

    /* Solo para entender el controlador */
    public function mensaje(){
        return "Hola, que tal?";
    }

    public function pago(){
        $dias = 7;
        $pago = 200;
        $nomina = $dias * $pago;
        return "El pago del empleado es $nomina";
    }

    public function nomina($dias, $pago){
        $nomina = $dias * $pago;
        //dd($nomina) es equivalente a un var_dump
        return "El pago de la nomina es $nomina ($dias dias x $$pago pago)";
    }

    /* Para la vista */

    /*forma de enviar variables a la vista*/
    public function saludo($nombre, $dias){

        /* *************** Regresa datos a la vista ***************** */

        //return view('empleado',compact('nombre','dias')); //forma 1
        //return view('empleado',['nombre' => $nombre, 'dias'=> $dias]); //forma 2 con array
        $pago = 100;
        $nomina = $dias*$pago;

        return view('empleado')->with('nombre', $nombre)->with('dias', $dias)->with('nomina', $nomina);//forma 3
    }

    public function salir(){
        return "Salir";
    }

    public function vb(){
        return view('vistaBootstrap');
    }

    public function altaEmpleado(){
        $consulta =  empleados::orderBy('ide', 'DESC')->take(1)->get();
        $cuantos = count($consulta);

        if ($cuantos == 0) {
            $siguiente = 1;
        }
        else{
            $siguiente = $consulta[0]->ide + 1;
        }

        $departamentos = departamentos::orderBy('nombre')->get();
        return view('altaEmpleado')->with('siguiente', $siguiente)->with('departamentos', $departamentos);
    }

    public function guardarEmpleado(Request $request){
        //se realizan validaciones
        //'ide' => 'required|regex:/^[A-Z]{3}[-][0-9]{5}$/',
        $this->validate($request, [
            'nombre'  =>  'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'apellido'  =>  'required|alpha',
            'email'  =>  'required|email',
            'celular'  =>  'required|regex:/^[0-9]{10}$/',
            'img' =>    'image|mimes:gif,jpeg,jpg,png'
        ]);
        $file = $request->file('img');
        
        if ($file<>"") {    
            $img = $file->getClientOriginalName();
            $img2 = $request->ide . $img;
            \Storage::disk('local')->put($img2,\File::get($file));
        }
        else{
            $img2 = "sin_foto.jpg";
        }
        

        $empleados =  new empleados;
        $empleados->nombre = $request->nombre;
        $empleados->apellido = $request->apellido;
        $empleados->email = $request->email;
        $empleados->celular = $request->celular;
        $empleados->sexo = $request->sexo;
        $empleados->descripcion = $request->detalle;
        $empleados->idd = $request->idd;
        $empleados->img = $img2;
        $empleados->save();
        /*
        return view('mensaje')->with('proceso',"Alta de empleados")->with('mensaje', "El el empleado $request->nombre ha sido guardado correctamente");
        */
        Session::flash('mensaje', "El el empleado $request->nombre ha sido guardado correctamente");
        return redirect()->route('reporteEmpleados');
    }

    //muestra
    public function reporteEmpleados(){
        $sessionId = session('idUsuario');
        $sessionTipo = session('tipoSesion');

        if ($sessionId<>"" and $sessionTipo<>"") {
            $consulta = empleados::withTrashed()->join('departamentos', 'empleados.idd','=','departamentos.idd')
            ->select('empleados.ide', 'empleados.nombre', 'empleados.apellido', 'departamentos.nombre as depa', 'empleados.email', 'empleados.deleted_at','empleados.img')->orderBy('empleados.nombre')->get();

            return view('reporte')->with('consulta', $consulta)->with('sessionTipo', $sessionTipo);
        }
        else{
            Session::flash('mensaje', "Logearse para continuar");
            return redirect()->route('login');
        }        
    }

    //elimina
    public function desactivaEmpleado($ide){
        $empleados = empleados::find($ide);
        $empleados->delete();
        /*
        return view('mensaje')->with('proceso',"Desactiva empleado")->with('mensaje', "El empleado ha sido desactivado correctamente");
        */
        Session::flash('mensaje', "El empleado ha sido desactivado correctamente");
        return redirect()->route('reporteEmpleados');
    }

    public function activaEmpleado($ide){
        $empleados = empleados::withTrashed()->where('ide',$ide)->restore();
        /*
        return view('mensaje')->with('proceso',"Activa empleado")->with('mensaje', "El empleado ha sido reactivado correctamente");
        */
        Session::flash('mensaje', "El empleado ha sido eliminado permanentemente");
        return redirect()->route('reporteEmpleados');
    }

    public function eliminarEmpleado($ide){
        $empleados =empleados::withTrashed()->find($ide)->forceDelete();
        /*
        return view('mensaje')->with('proceso',"Elimina empleado")->with('mensaje', "El empleado ha sido eliminado permanentemente");
        */
        Session::flash('mensaje', "El empleado ha sido eliminado permanentemente");
        return redirect()->route('reporteEmpleados');
    }

    //modificar

    public function modificaEmpleado($ide){
        $departamentos = departamentos::orderBy('nombre')->get();
        $consulta = empleados::withTrashed()->join('departamentos', 'empleados.idd','=','departamentos.idd')
        ->select('empleados.ide', 'empleados.nombre', 'empleados.apellido', 'departamentos.nombre as depa', 'empleados.email', 'empleados.celular', 'empleados.sexo', 'empleados.descripcion', 'empleados.idd', 'empleados.img', 'empleados.deleted_at')->where('ide', $ide)->get();


        return view('modificaEmpleado')->with('departamentos', $departamentos)->with('consulta',$consulta[0]);
    }

    public function guardaEmpleado(Request $request){
        $this->validate($request, [
            'nombre'  =>  'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'apellido'  =>  'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú]+$/',
            'email'  =>  'required|email',
            'celular'  =>  'required|regex:/^[0-9]{10}$/',
            'img' =>    'image|mimes:gif,jpeg,jpg,png'
        ]);


        $file = $request->file('img');
        if ($file<>"") {    
            $img = $file->getClientOriginalName();
            $img2 = $request->ide . $img;
            \Storage::disk('local')->put($img2,\File::get($file));
        }


        $empleados = empleados::withTrashed()->find($request->ide);
        $empleados->nombre = $request->nombre;
        $empleados->apellido = $request->apellido;
        $empleados->email = $request->email;
        $empleados->celular = $request->celular;
        $empleados->sexo = $request->sexo;
        $empleados->descripcion = $request->detalle;
        $empleados->idd = $request->idd;
        if ($file<>"") {  
            $empleados->img = $img2;
        }
        $empleados->save();

        /*
        return view('mensaje')->with('proceso',"Modificación de empleados")->with('mensaje', "El empleado $request->nombre ha sido modificado correctamente");
        */

        Session::flash('mensaje', "El empleado $request->nombre ha sido modificado correctamente");
        return redirect()->route('reporteEmpleados');
    }

    




    public function eloquent(){
        /* Consulta (Mostrar):

            $consulta = empleados::all();
            return $consulta;

            //consulta con where
            $consulta = empleados::where('sexo','F')->get();
            return $consulta;
            
            //consulta de rangos de edad
            $consulta = empleados::where('edad','>=','20')->where('edad','<=','30')->get();
            return $consulta;

            $consulta = empleados::whereBetween('edad',[20,30])->get();
            return $consulta;

            $consulta = empleados::whereIn('ide',[1,2,3])->get(); //trae datos indicados
            return $consulta;

            $consulta = empleados::whereIn('ide',[1,2,3])->orderBy('nombre','desc')->get(); //trae datos ordenados
            return $consulta;


            $consulta = empleados::whereBetween('edad',[20,30])->take(2)->get(); //toma los dos primeros registros
            return $consulta;


            $consulta = empleados::where('edad','>=','20')->orwhere('sexo','F')->get();
            return $consulta;

        */

        /*  Insertar forma 1

        $empleados =  new empleados;
        $empleados->nombre = 'Joel';
        $empleados->apellido = 'Lara';
        $empleados->email = 'joel@gmail.com';
        $empleados->celular = '5512345678';
        $empleados->sexo = 'M';
        $empleados->descripcion = 'a su maquina, a ver si se puede';
        $empleados->idd = 1;
        $empleados->edad = 18;
        $empleados->salario = 120;
        $empleados->save();
        return "Operación realizada";
        */
        

        /*  Insertar forma 2
        $datos = [
            'nombre' => 'Lucia',
            'apellido'  =>  'Mendez',
            'email'  =>  'lume@correo.com',
            'celular'  =>  '5679232345',
            'sexo'  =>  'F',
            'descripcion'  =>  'Vamos a ver mi experimento con JSON',
            'idd'  =>  1,
            'edad'  =>  23,
            'salario'  => 200
        ];
        $empleados = empleados::create($datos);
        return "Operación realizada";
        */
        

        /*Actualización de datos

        $empleados = empleados::find(1);
        $empleados->nombre = "Dulce Ivonne";
        $empleados->apellido = "Aviles Quintanilla";
        $empleados->save();
        return "Modificación  realizada";

        */

        /*Actualización multiple

        empleados::where('sexo','M')
        ->where('email','joel@gmail.com')
        ->update(['nombre'=>'Drake', 'celular' =>'1234567890'] );
        return "Modificación  realizada";

        */

        /*eliminar un registro forma 1

        empleados::destroy(1);
        return "Registro eliminado";

        */

        /*eliminar un registro forma 2

        $empleados = empleados::find(2);
        $empleados->delete();
        return "Registro eliminado";
        */

        /*eliminar registro sin conocer clave primaria
        $empleados = empleados::where('sexo','F')->where('celular','1234567890')->delete();
        return "Registro eliminado";
        */

        // *************************** Softdeletes ****************************
        /* Softdeletes: borra el registro de forma logica, indicando con una fecha el dia de eliminación

        $empleados = empleados::find(4);
        $empleados->delete();
        return "Registro eliminado";
        
        //comprobamos
        $consulta = empleados::all();
        return $consulta;

        //aqui traemos la información con los datos eliminados
        $consulta = empleados::withTrashed()->get();
        return $consulta;
        
        // obtener solo los eliminados
        $consulta = empleados::onlyTrashed()->get();
        return $consulta;
        
        //obtener con filtrados
        $consulta = empleados::onlyTrashed()->where('sexo', 'F')->get();
        return $consulta;

        //restaurar eliminados
            empleados::withTrashed()->where('ide',4)->restore();
            return "Restauración realizada";

        // Elimina definitivamente
            $empleados =empleados::find(4)->forceDelete();
            return "Eliminado permanentemente";


        */

        /* ********************** Consulta multiples tablas *************************    

        //obtiene solo los campos indicados
        $consulta = empleados::select(['nombre','apellido','edad'])->where('edad','>=','30')->get();
        

        //usando like
        $consulta = empleados::select(['nombre','apellido','edad'])->where('nombre','LIKE','%as%')->get();
        
        //sumando con condiciones
        $consulta = empleados::where('sexo','F')->sum('salario');

        //groupby muestra la suma de salarios por genero
        $consulta = empleados::groupBY('sexo')->selectRaw('sexo,sum('salario') as salarioTotal')->get();

        //contar cuantas personas hay de cada sexo
        $consulta = empleados::groupBY('sexo')->selectRaw('sexo,count(*) as cantidad')->get();

        //inner join
        $consulta = empleados::join('departamentos', 'empleados.idd','=','departamentos.idd')
        ->select('empleados.ide', 'empleados.nombre', 'departamentos.nombre as depa', 'empleados.edad')
        ->where('empleados.edad','>=','30')->get();
        return $consulta;

        */
        return "esto es eloquent";


    }

}
