<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguroMedico extends Model
{
    use HasFactory;

    protected $table = 'seguros_medicos';
    protected $primaryKey = 'id_seguro_medico';
    public $timestamps = false;

    protected $fillable = [
        'id_seguro_medico',
        'nombre',
        'tipo_plan',
        'porcentaje_cobertura',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id_seguro_medico', 'id_seguro_medico');
    }
}
