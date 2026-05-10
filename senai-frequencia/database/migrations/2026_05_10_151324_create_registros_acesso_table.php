<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registros_acesso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->cascadeOnDelete();
            $table->enum('tipo', ['entrada_portaria', 'entrada_bloco', 'saida']);
            $table->string('local')->nullable(); // ex: Bloco A, Portaria
            $table->timestamp('registrado_em');
            $table->enum('status', ['ok', 'bloco_errado', 'ausente_sala'])->default('ok');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_acesso');
    }
};