<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaResiduo extends Model
{
    use HasFactory;

    protected $table = 'entradas_residuos';
    
    protected $fillable = [
        'codigo_lote',
        'data_hora_entrada',
        'origem_id',
        'categoria_id',
        'quantidade',
        'unidade_medida',
        'estado',
        'operador_id',
        'observacoes'
    ];

    protected $casts = [
        'data_hora_entrada' => 'datetime',
        'quantidade' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($entrada) {
            $entrada->codigo_lote = 'LOT-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function origem()
    {
        return $this->belongsTo(OrigemResiduo::class, 'origem_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaPlastico::class, 'categoria_id');
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoResiduo::class, 'entrada_id');
    }
}