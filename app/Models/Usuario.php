<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_usuario',
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
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    public function rol(){
        return $this->belongsTo(Rol::class,'id_rol');
    }

    public $timestamps = false;
}
