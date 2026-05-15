<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('saidas_antecipadas') || !Schema::hasTable('solicitacoes_saida')) {
            return;
        }

        DB::table('saidas_antecipadas')
            ->orderBy('id')
            ->get()
            ->each(function ($saida) {
                $aluno = DB::table('alunos')->where('id', $saida->aluno_id)->first();

                if (!$aluno || !$aluno->turma_id) {
                    return;
                }

                $horario = \Carbon\Carbon::parse($saida->horario_saida);
                $existe = DB::table('solicitacoes_saida')
                    ->where('aluno_id', $saida->aluno_id)
                    ->whereDate('data', $horario->toDateString())
                    ->where('horario_saida', $horario->format('H:i:s'))
                    ->exists();

                if ($existe) {
                    return;
                }

                $status = match ($saida->status) {
                    'autorizada' => 'justificado',
                    'nao_autorizada' => 'falta_mantida',
                    default => 'pendente',
                };

                $id = DB::table('solicitacoes_saida')->insertGetId([
                    'aluno_id' => $saida->aluno_id,
                    'professor_id' => $saida->solicitado_por_id,
                    'turma_id' => $aluno->turma_id,
                    'frequencia_id' => null,
                    'data' => $horario->toDateString(),
                    'horario_saida' => $horario->format('H:i:s'),
                    'motivo' => $saida->motivo ?? 'Nao informado',
                    'observacoes' => 'Importado do fluxo antigo de saidas antecipadas.',
                    'apresentou_justificativa' => false,
                    'autorizado_saida' => $saida->status === 'autorizada',
                    'status' => $status,
                    'analisado_por' => $saida->validado_por_id,
                    'data_analise' => $saida->validado_em,
                    'created_at' => $saida->created_at,
                    'updated_at' => now(),
                ]);

                DB::table('historico_solicitacoes_saida')->insert([
                    'solicitacao_saida_id' => $id,
                    'user_id' => $saida->solicitado_por_id,
                    'acao' => 'importado_fluxo_antigo',
                    'descricao' => 'Registro importado da tabela saidas_antecipadas.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('historico_solicitacoes_saida')
            ->where('acao', 'importado_fluxo_antigo')
            ->delete();

        DB::table('solicitacoes_saida')
            ->where('observacoes', 'Importado do fluxo antigo de saidas antecipadas.')
            ->delete();
    }
};
