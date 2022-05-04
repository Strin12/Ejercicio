<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class estados extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'estados';

    protected $fillable = [
        'id',
        'cod_estado',
        'estado'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];
    
    public function municipios(){
        return $this->hasOne(municipios::class);
    }
}
