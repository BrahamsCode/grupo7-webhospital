<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'imagen_url',
        'codigo_medicamento',
        'descripcion',
        'presentacion',
        'dosis_recomendada',
        'fecha_vencimiento',
        'laboratorio',
        'stock',
        'precio',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function detallesReceta()
    {
        return $this->hasMany(DetalleReceta::class, 'id_medicamento', 'id_medicamento');
    }
}
