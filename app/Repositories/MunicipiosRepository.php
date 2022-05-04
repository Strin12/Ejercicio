<?php
namespace App\Repositories;

use APP\Models\municipios;

class MunicipiosRepository{

public function create($municipio, $estados_id){

        $municipios['municipio'] = $municipio;
        $municipio['estados_id'] = $estados_id;
        return municipios::create($municipios);

}


}