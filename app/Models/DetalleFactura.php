<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $table = 'detalles_factura';
    protected $primaryKey = 'id_detalle_factura';
    public $timestamps = false;

    protected $fillable = [
        'id_factura',
        'concepto',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'tipo',
        'id_referencia',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura');
    }
}
