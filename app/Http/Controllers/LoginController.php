<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash; //encripta
use Illuminate\Http\Request;

use App\Models\usuarios;
use Session;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function autenticar(Request $request){
        $this->validate($request, [
            'usuario'  =>  'required',
            'pass'  =>  'required'
        ]);

        $consulta = usuarios::where('user', $request->usuario)->where('activo',"si")->get();
        $cantidad = count($consulta);
        if ($cantidad == 1 && hash::check($request->pass,$consulta[0]->pasw)) {
            //crear sesion
            Session::put('sesionUsuario',$consulta[0]->nombre.' '.$consulta[0]->apellido);
            Session::put('tipoSesion',$consulta[0]->tipo);
            Session::put('idUsuario',$consulta[0]->idu);
            /* Para proteger la pagina, debe modificarse la funcion que lo administra

            */

            return redirect()->route('reporteEmpleados');
        }
        else{
            Session::flash('mensaje', "La información no es valida");
            return redirect()->route('login');
        }

        /*
        $password_encript = Hash::make($request->pass);
        return $password_encript;
        */
    }

    public function cerrarSesion(){
        Session::forget('sesionUsuario');
        Session::forget('tipoSesion');
        Session::forget('idUsuario');
        Session::flush();
        Session::flash('mensaje', "Sesión cerrada correctamente");
        return redirect()->route('login');
    }
}
