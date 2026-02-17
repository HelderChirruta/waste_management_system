<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permissao;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Criar permissões
        $permissoes = [
            ['nome' => 'gerir_utilizadores', 'descricao' => 'Gerir utilizadores do sistema'],
            ['nome' => 'gerir_categorias', 'descricao' => 'Gerir categorias de plástico'],
            ['nome' => 'registar_entradas', 'descricao' => 'Registar entradas de resíduos'],
            ['nome' => 'visualizar_relatorios', 'descricao' => 'Visualizar relatórios'],
            ['nome' => 'gerir_catadores', 'descricao' => 'Gerir catadores'],
            ['nome' => 'aprovar_registos', 'descricao' => 'Aprovar registos'],
        ];
        
        foreach ($permissoes as $permissao) {
            Permissao::create($permissao);
        }
        
        // Criar roles
        $admin = Role::create([
            'nome' => 'Administrador',
            'descricao' => 'Acesso total ao sistema'
        ]);
        
        $gestor = Role::create([
            'nome' => 'Gestor',
            'descricao' => 'Gestor da lixeira'
        ]);
        
        $operador = Role::create([
            'nome' => 'Operador',
            'descricao' => 'Operador administrativo'
        ]);
        
        $supervisor = Role::create([
            'nome' => 'Supervisor Ambiental',
            'descricao' => 'Supervisor ambiental'
        ]);
        
        // Atribuir permissões
        $admin->permissoes()->attach(Permissao::all());
        $gestor->permissoes()->attach(Permissao::whereIn('nome', ['visualizar_relatorios', 'aprovar_registos'])->get());
        $operador->permissoes()->attach(Permissao::whereIn('nome', ['registar_entradas', 'gerir_catadores'])->get());
    }
}