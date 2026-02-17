<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('documento_identificacao', 30)->unique();
            $table->date('data_nascimento')->nullable();
            $table->string('contato', 20);
            $table->string('endereco')->nullable();
            $table->date('data_cadastro');
            $table->boolean('ativo')->default(true);
            $table->foreignId('cadastrado_por')->constrained('users');
            $table->timestamps();
        });

        Schema::create('coletas_catadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catador_id')->constrained();
            $table->date('data_coleta');
            $table->foreignId('categoria_id')->constrained('categorias_plastico');
            $table->decimal('quantidade_kg', 10, 2);
            $table->decimal('valor_pago', 10, 2)->nullable();
            $table->foreignId('registrado_por')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coletas_catadores');
        Schema::dropIfExists('catadores');
    }
};