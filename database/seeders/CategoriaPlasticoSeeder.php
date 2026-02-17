<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaPlastico;

class CategoriaPlasticoSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'codigo' => 'PET',
                'nome' => 'PET',
                'descricao' => 'Politereftalato de Etileno',
                'valor_estimado_kg' => 25.00
            ],
            [
                'codigo' => 'PEAD',
                'nome' => 'PEAD',
                'descricao' => 'Polietileno de Alta Densidade',
                'valor_estimado_kg' => 20.00
            ],
            [
                'codigo' => 'PVC',
                'nome' => 'PVC',
                'descricao' => 'Policloreto de Vinila',
                'valor_estimado_kg' => 15.00
            ],
            [
                'codigo' => 'PP',
                'nome' => 'PP',
                'descricao' => 'Polipropileno',
                'valor_estimado_kg' => 22.00
            ],
            [
                'codigo' => 'OUTROS',
                'nome' => 'Outros Plásticos',
                'descricao' => 'Outros tipos de plástico',
                'valor_estimado_kg' => 10.00
            ],
        ];
        
        foreach ($categorias as $categoria) {
            CategoriaPlastico::create($categoria);
        }
    }
}