<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoResiduo extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes_residuos';
    
    protected $fillable = [
        'entrada_id',
        'tipo_movimentacao',
        'quantidade',
        'localizacao',
        'responsavel_id',
        'destino',
        'data_movimentacao',
        'observacoes'
    ];

    protected $casts = [
        'data_movimentacao' => 'datetime',
        'quantidade' => 'decimal:2'
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaResiduo::class, 'entrada_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}