<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'role_permissao', 'role_id', 'permissao_id');
    }
}