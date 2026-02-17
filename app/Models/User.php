<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nome_completo',
        'email',
        'password',
        'role_id',
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermissao($permissaoNome)
    {
        return $this->role && $this->role->permissoes()->where('nome', $permissaoNome)->exists();
    }

    // Relacionamentos adicionais
    public function entradasRegistadas()
    {
        return $this->hasMany(EntradaResiduo::class, 'operador_id');
    }

    public function movimentacoesResponsavel()
    {
        return $this->hasMany(MovimentacaoResiduo::class, 'responsavel_id');
    }

    public function catadoresCadastrados()
    {
        return $this->hasMany(Catador::class, 'cadastrado_por');
    }

    public function coletasRegistadas()
    {
        return $this->hasMany(ColetaCatador::class, 'registrado_por');
    }
}