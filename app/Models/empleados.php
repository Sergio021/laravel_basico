<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Softdeletes; //agregamos libreria

class empleados extends Model
{
    use HasFactory;
    use Softdeletes;    //tambien añadimos esto

    protected $primaryKey='ide';
    protected $fillable = ['ide', 'nombre', 'apellido', 'email', 'celular', 'sexo', 'idd', 'descripcion', 'edad','salario', 'img'];
}
