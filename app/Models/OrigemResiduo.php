<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigemResiduo extends Model
{
    use HasFactory;

    protected $table = 'origens_residuo';
    
    protected $fillable = [
        'nome',
        'tipo',
        'contato'
    ];

    public function entradas()
    {
        return $this->hasMany(EntradaResiduo::class, 'origem_id');
    }
}