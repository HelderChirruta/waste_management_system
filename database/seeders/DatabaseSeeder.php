<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar roles
        $adminRole = Role::create([
            'nome' => 'Administrador',
            'descricao' => 'Usuário com todos os privilégios',
        ]);

        $gestorRole = Role::create([
            'nome' => 'Gestor',
            'descricao' => 'Usuário gestor',
        ]);

        $operadorRole = Role::create([
            'nome' => 'Operador',
            'descricao' => 'Usuário operador',
        ]);

        // Criar Admin
        User::create([
            'nome_completo' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
            'ativo' => true,
        ]);

        // Usuários de teste (opcional)
        User::factory(10)->create([
            'role_id' => $operadorRole->id
        ]);
    }
}
