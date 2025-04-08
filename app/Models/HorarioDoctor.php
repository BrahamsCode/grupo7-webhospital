<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDoctor extends Model
{
    use HasFactory;

    protected $table = 'horarios_doctores';
    protected $primaryKey = 'id_horario_doctor';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_doctor',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function doctor()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_doctor', 'id_usuario');
    }
}
