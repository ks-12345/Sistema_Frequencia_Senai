<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\HistoricoSolicitacaoSaida;
use App\Models\SolicitacaoSaida;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Database\Seeder;

class FluxoSaidaAntecipadaSeeder extends Seeder
{
    public function run(): void
    {
        $aluno = Aluno::first();
        $professor = User::where('role', 'professor')->first();
        $turma = $aluno?->turma ?? Turma::first();

        if (!$aluno || !$professor || !$turma) {
            return;
        }

        $solicitacao = SolicitacaoSaida::firstOrCreate(
            [
                'aluno_id' => $aluno->id,
                'data' => today(),
            ],
            [
                'professor_id' => $professor->id,
                'turma_id' => $turma->id,
                'horario_saida' => '15:30',
                'motivo' => 'Consulta medica informada pelo aluno.',
                'observacoes' => 'Registro demonstrativo criado pelo seeder.',
                'apresentou_justificativa' => false,
                'autorizado_saida' => false,
                'status' => 'pendente',
            ]
        );

        HistoricoSolicitacaoSaida::firstOrCreate([
            'solicitacao_saida_id' => $solicitacao->id,
            'acao' => 'seeder_demo',
        ], [
            'user_id' => $professor->id,
            'descricao' => 'Solicitacao demonstrativa para testar o fluxo.',
        ]);
    }
}
