<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE frequencias MODIFY status_presenca ENUM('presente','falta','atraso','saida_antecipada') NOT NULL");
        }

        Schema::create('solicitacoes_saida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('turma_id')->constrained()->cascadeOnDelete();
            $table->foreignId('frequencia_id')->nullable()->constrained('frequencias')->nullOnDelete();
            $table->date('data');
            $table->time('horario_saida');
            $table->text('motivo');
            $table->text('observacoes')->nullable();
            $table->boolean('apresentou_justificativa')->default(false);
            $table->boolean('autorizado_saida')->default(false);
            $table->enum('status', ['pendente', 'em_analise', 'aprovado', 'recusado', 'falta_mantida', 'justificado'])->default('pendente');
            $table->foreignId('analisado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('data_analise')->nullable();
            $table->timestamps();
        });

        Schema::create('justificativas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitacao_saida_id')->constrained('solicitacoes_saida')->cascadeOnDelete();
            $table->text('descricao');
            $table->string('arquivo')->nullable();
            $table->enum('status', ['pendente', 'em_analise', 'aprovado', 'recusado', 'falta_mantida', 'justificado'])->default('pendente');
            $table->foreignId('analisado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('data_analise')->nullable();
            $table->timestamps();
        });

        Schema::create('tentativas_saida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained()->cascadeOnDelete();
            $table->timestamp('data_hora');
            $table->enum('resultado', ['liberado', 'bloqueado']);
            $table->text('motivo_bloqueio')->nullable();
            $table->timestamps();
        });

        Schema::create('historico_solicitacoes_saida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitacao_saida_id')->constrained('solicitacoes_saida')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('acao');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_solicitacoes_saida');
        Schema::dropIfExists('tentativas_saida');
        Schema::dropIfExists('justificativas');
        Schema::dropIfExists('solicitacoes_saida');

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE frequencias MODIFY status_presenca ENUM('presente','falta','atraso') NOT NULL");
        }
    }
};
