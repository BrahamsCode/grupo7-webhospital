<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'tipo_documento',
        'numero_documento',
        'correo',
        'password',
        'genero',
        'telefono',
        'fecha_nacimiento',
        'id_rol',
        'id_especialidad',
        'ultimo_acceso',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    protected $hidden = [
        'password',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad', 'id_especialidad');
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'id_usuario', 'id_usuario');
    }

    public function horariosDoctores()
    {
        return $this->hasMany(HorarioDoctor::class, 'id_usuario_doctor', 'id_usuario');
    }

    public function citasDoctor()
    {
        return $this->hasMany(Cita::class, 'id_usuario_doctor', 'id_usuario');
    }
}
