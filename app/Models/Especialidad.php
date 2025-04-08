<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';
    protected $primaryKey = 'id_especialidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'imagen_url',
        'descripcion',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_especialidad', 'id_especialidad');
    }
}
