<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguroMedico extends Model
{
    protected $table = 'seguros_medicos';
    protected $primaryKey = 'id_seguro_medico';
    public $timestamps = false;

    protected $fillable = [
        'id_seguro_medico',
        'nombre',
        'tipo_plan',
        'porcentaje_cobertura'
    ];
}
