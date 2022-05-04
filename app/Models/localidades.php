<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class localidades extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'localidades';

    protected $fillable = [
        'id',
        'id_asenta',
        'd_asenta',
        'd_tipo_asenta',
        'cod_postal',
        'd_codigo',
        'd_ciudad',
        'c_oficina',
        'd_zona',
        'c_tipo_asenta',
        'claveciudad',
        'c_mnpio',
        'municipios_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];
    public function municipios(){
        return $this->belongsTo(municipios::class);
    }
}
