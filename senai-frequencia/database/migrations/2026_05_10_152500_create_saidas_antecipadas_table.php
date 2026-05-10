<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saidas_antecipadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->cascadeOnDelete();
            $table->foreignId('solicitado_por_id')->constrained('users');
            $table->foreignId('validado_por_id')->nullable()->constrained('users');
            $table->timestamp('horario_saida');
            $table->text('motivo')->nullable();
            $table->enum('status', ['pendente', 'autorizada', 'nao_autorizada'])->default('pendente');
            $table->text('observacao_secretaria')->nullable();
            $table->timestamp('validado_em')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saidas_antecipadas');
    }
};