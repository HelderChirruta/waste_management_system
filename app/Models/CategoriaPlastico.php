<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPlastico extends Model
{
    use HasFactory;

    protected $table = 'categorias_plastico';
    
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'valor_estimado_kg'
    ];

    protected $casts = [
        'valor_estimado_kg' => 'decimal:2'
    ];

    public function entradas()
    {
        return $this->hasMany(EntradaResiduo::class, 'categoria_id');
    }

    public function coletas()
    {
        return $this->hasMany(ColetaCatador::class, 'categoria_id');
    }
}