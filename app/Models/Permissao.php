<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $table = 'permissoes';
    
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissao', 'permissao_id', 'role_id');
    }
}