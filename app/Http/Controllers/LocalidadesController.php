<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LocalidadesRepository;

class LocalidadesController extends Controller
{
    
    //se declara una variable donde recibira el repositorio de localidades
    protected $localidades; 
    //se declara un contruct para obtener las funciones generadas en el repositorio
    public function __construct(LocalidadesRepository $localidad)
    {
        $this->localidades = $localidad;
    }
    //la funcion donde se agregara los datos del excell recibiendo un request
    public function addLocalidades(Request $request)
    {
        //obteniendo el request lo manda al repositorio esto considerando el principio Solid una de las maneras en las que se aplica en laravel.  
        return $this->localidades->addLocalidades($request);
    }

    
}
