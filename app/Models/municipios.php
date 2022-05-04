<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class municipios extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'municipios';

    protected $fillable = [
        'id',
        'c_mnpio',
        'municipio',
        'cod_estado',
        'estados_id'
    ];
    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];
    public function estados(){
        return $this->belongsTo(estados::class);
    }
}
