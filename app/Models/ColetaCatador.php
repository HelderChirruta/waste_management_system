<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColetaCatador extends Model
{
    use HasFactory;

    protected $table = 'coletas_catadores';
    
    protected $fillable = [
        'catador_id',
        'data_coleta',
        'categoria_id',
        'quantidade_kg',
        'valor_pago',
        'registrado_por'
    ];

    protected $casts = [
        'data_coleta' => 'date',
        'quantidade_kg' => 'decimal:2',
        'valor_pago' => 'decimal:2'
    ];

    public function catador()
    {
        return $this->belongsTo(Catador::class);
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaPlastico::class, 'categoria_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}