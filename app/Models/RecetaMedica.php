<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaMedica extends Model
{
    use HasFactory;

    protected $table = 'recetas_medicas';
    protected $primaryKey = 'id_receta';
    public $timestamps = false;

    protected $fillable = [
        'id_cita',
        'fecha_emision',
        'estado',
        'instrucciones',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita', 'id_cita');
    }

    public function detallesReceta()
    {
        return $this->hasMany(DetalleReceta::class, 'id_receta', 'id_receta');
    }
}
