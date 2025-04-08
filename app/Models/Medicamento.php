<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';
    public $timestamps = false;
    protected $fillable = [
        'id_medicamento',
        'imagen_url',
        'nombre',
        'codigo_medicamento',
        'descripcion',
        'presentacion',
        'dosis_recomendada',
        'fecha_vencimiento',
        'laboratorio',
        'stock',
        'precio',
        'estado_auditoria',        
    ];
    
}
