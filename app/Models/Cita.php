<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'id_usuario_doctor',
        'fecha_cita',
        'estado',
        'notas',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function doctor()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_doctor', 'id_usuario');
    }

    public function recetasMedicas()
    {
        return $this->hasMany(RecetaMedica::class, 'id_cita', 'id_cita');
    }

    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class, 'id_cita', 'id_cita');
    }
}
