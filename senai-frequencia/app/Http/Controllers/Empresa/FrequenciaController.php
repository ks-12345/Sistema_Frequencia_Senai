<?php

namespace App\Http\Controllers\Empresa;

use App\Exports\EmpresaFrequenciasExport;
use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FrequenciaController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with(['turma', 'frequencias'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->orderBy('nome')
            ->get();

        return view('empresa.frequencia.index', compact('alunos'));
    }

    public function show(Aluno $aluno)
    {
        // Garante que a empresa só vê seus próprios alunos
        if ($aluno->empresa_id !== Auth::user()->empresa_id) {
            abort(403);
        }

        // Empresa só pode visualizar frequências aprovadas pela Secretaria
        $frequencias = Frequencia::with('lancadoPor')
            ->where('aluno_id', $aluno->id)
            ->where('status', 'aprovado')
            ->orderBy('data', 'desc')
            ->paginate(20);


        $total     = $frequencias->total();
        $presencas = Frequencia::where('aluno_id', $aluno->id)
                               ->where('status_presenca', 'presente')
                               ->count();
        $percentual = $total > 0 ? round(($presencas / $total) * 100, 1) : 0;

        return view('empresa.frequencia.show', compact('aluno', 'frequencias', 'percentual'));
    }

    public function exportar(Request $request)
    {
        $request->validate([
            'formato' => 'required|in:xlsx,csv',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $empresaId = Auth::user()->empresa_id;

        $frequencias = Frequencia::with(['aluno.turma', 'lancadoPor'])
            ->where('status', 'aprovado')
            ->whereHas('aluno', fn ($query) => $query->where('empresa_id', $empresaId))
            ->when($request->data_inicio, fn ($query) => $query->whereDate('data', '>=', $request->data_inicio))
            ->when($request->data_fim, fn ($query) => $query->whereDate('data', '<=', $request->data_fim))

            ->orderBy('data', 'desc')
            ->orderBy(
                Aluno::select('nome')
                    ->whereColumn('alunos.id', 'frequencias.aluno_id')
                    ->limit(1)
            )
            ->get();

        $extensao = $request->formato;
        $writer = $extensao === 'csv'
            ? \Maatwebsite\Excel\Excel::CSV
            : \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new EmpresaFrequenciasExport($frequencias),
            'frequencias_empresa_'.now()->format('Ymd_His').'.'.$extensao,
            $writer
        );
    }
}
