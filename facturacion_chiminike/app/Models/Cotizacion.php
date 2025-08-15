<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion'; 
    protected $primaryKey = 'cod_cotizacion'; 

    protected $fillable = [
        // ✅ lista de campos permitidos para fill (opcional, puedes dejar vacío si solo consultas)
    ];

    // Si tu tabla no tiene created_at, updated_at:
    public $timestamps = false;

    // Si necesitas relaciones (ejemplo con cliente):
    // public function cliente() {
    //     return $this->belongsTo(Cliente::class, 'cod_cliente', 'cod_cliente');
    // }
}
