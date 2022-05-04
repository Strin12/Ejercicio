<?php
namespace App\Repositories;

use App\Models\estados;

class EstadosReposiroy {

public function create($estado){

    $estados['estado'] = $estado;
    return estados::create($estados);

}
public function list(){
    return estados::all();
}


}