<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'direccion',
        'id_seguro_medico',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function seguroMedico()
    {
        return $this->belongsTo(SeguroMedico::class, 'id_seguro_medico', 'id_seguro_medico');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_paciente', 'id_paciente');
    }

    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class, 'id_paciente', 'id_paciente');
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'id_paciente', 'id_paciente');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_paciente', 'id_paciente');
    }
}
