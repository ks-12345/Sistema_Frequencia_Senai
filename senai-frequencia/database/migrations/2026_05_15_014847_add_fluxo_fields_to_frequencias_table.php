<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('frequencias', function (Blueprint $table) {
            // Status do fluxo Professor -> Secretaria -> Empresa
            $table->enum('status', [
                'rascunho',
                'pendente_aprovacao',
                'aprovado',
                'devolvido_correcao',
            ])->default('rascunho')->after('status_aprovacao');

            $table->timestamp('enviado_secretaria_em')->nullable()->after('status');
            $table->timestamp('aprovado_secretaria_em')->nullable()->after('enviado_secretaria_em');
            $table->foreignId('aprovado_por')->nullable()->after('aprovado_secretaria_em')->constrained('users');
            $table->text('motivo_devolucao')->nullable()->after('aprovado_por');
        });

        // Mapeamento inicial baseado no status_aprovacao existente.
        // - aprovado  -> aprovado
        // - pendente  -> pendente_aprovacao
        // - rejeitado -> devolvido_correcao

        DB::table('frequencias')->update([
            'status' => DB::raw("CASE 
                WHEN status_aprovacao = 'aprovado' THEN 'aprovado'
                WHEN status_aprovacao = 'pendente' THEN 'pendente_aprovacao'
                WHEN status_aprovacao = 'rejeitado' THEN 'devolvido_correcao'
                ELSE 'rascunho'
            END")
        ]);


    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frequencias', function (Blueprint $table) {
            //
        });
    }
};
