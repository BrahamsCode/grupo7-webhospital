<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $table = 'tratamientos';
    protected $primaryKey = 'id_tratamiento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class, 'id_tratamiento', 'id_tratamiento');
    }
}
