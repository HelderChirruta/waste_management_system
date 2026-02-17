<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimentacoes_residuos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->constrained('entradas_residuos')->onDelete('cascade');
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
    }
};