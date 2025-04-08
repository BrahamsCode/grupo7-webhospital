<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    use HasFactory;

    protected $table = 'detalles_receta';
    protected $primaryKey = 'id_detalle_receta';
    public $timestamps = false;

    protected $fillable = [
        'id_receta',
        'id_medicamento',
        'cantidad',
        'dosis',
        'frecuencia',
        'duracion',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function receta()
    {
        return $this->belongsTo(RecetaMedica::class, 'id_receta', 'id_receta');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento', 'id_medicamento');
    }
}
