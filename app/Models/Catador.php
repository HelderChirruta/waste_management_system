<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catador extends Model
{
    use HasFactory;

    protected $table = 'catadores';
    
    protected $fillable = [
        'nome_completo',
        'documento_identificacao',
        'data_nascimento',
        'contato',
        'endereco',
        'data_cadastro',
        'ativo',
        'cadastrado_por'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_cadastro' => 'date',
        'ativo' => 'boolean'
    ];

    public function cadastradoPor()
    {
        return $this->belongsTo(User::class, 'cadastrado_por');
    }

    public function coletas()
    {
        return $this->hasMany(ColetaCatador::class, 'catador_id');
    }

    public function getTotalColetadoAttribute()
    {
        return $this->coletas()->sum('quantidade_kg');
    }
}