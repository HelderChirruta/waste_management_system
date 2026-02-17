<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias_plastico', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->decimal('valor_estimado_kg', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('origens_residuo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo'); // municipal, privado, outro
            $table->string('contato')->nullable();
            $table->timestamps();
        });

        Schema::create('entradas_residuos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_lote', 50)->unique();
            $table->datetime('data_hora_entrada');
            $table->foreignId('origem_id')->constrained('origens_residuo');
            $table->foreignId('categoria_id')->constrained('categorias_plastico');
            $table->decimal('quantidade', 10, 2);
            $table->string('unidade_medida', 10); // kg, ton
            $table->string('estado', 30); // misturado, separado, contaminado
            $table->foreignId('operador_id')->constrained('users');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        Schema::create('movimentacoes_residuos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->constrained('entradas_residuos');
            $table->string('tipo_movimentacao'); // separacao, armazenamento, venda, descarte
            $table->decimal('quantidade', 10, 2);
            $table->string('localizacao')->nullable();
            $table->foreignId('responsavel_id')->constrained('users');
            $table->string('destino')->nullable();
            $table->datetime('data_movimentacao');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentacoes_residuos');
        Schema::dropIfExists('entradas_residuos');
        Schema::dropIfExists('origens_residuo');
        Schema::dropIfExists('categorias_plastico');
    }
};