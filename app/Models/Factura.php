<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'fecha_emision',
        'monto_total',
        'monto_seguro',
        'monto_final',
        'estado',
        'estado_auditoria',
        'fecha_creacion_auditoria'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function detallesFactura()
    {
        return $this->hasMany(DetalleFactura::class, 'id_factura', 'id_factura');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_factura', 'id_factura');
    }
}
