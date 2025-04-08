<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';
    protected $primaryKey = 'id_habitacion';
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'tipo_habitacion',
        'estado_habitacion',
        'observacion',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'id_habitacion', 'id_habitacion');
    }
}
