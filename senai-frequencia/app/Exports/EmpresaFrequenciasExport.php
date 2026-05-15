<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmpresaFrequenciasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private readonly Collection $frequencias)
    {
    }

    public function collection(): Collection
    {
        return $this->frequencias;
    }

    public function headings(): array
    {
        return [
            'Data',
            'Aluno',
            'Matricula',
            'CPF',
            'Email',
            'Turma',
            'Curso',
            'Status',
            'Status aprovacao',
            'Lancado por',
            'Observacao',
        ];
    }

    public function map($frequencia): array
    {
        return [
            optional($frequencia->data)->format('d/m/Y'),
            $frequencia->aluno->nome ?? '',
            $frequencia->aluno->matricula ?? '',
            $frequencia->aluno->cpf ?? '',
            $frequencia->aluno->email ?? '',
            $frequencia->aluno->turma->nome ?? '',
            $frequencia->aluno->turma->curso ?? '',
            str_replace('_', ' ', ucfirst($frequencia->status_presenca)),
            ucfirst($frequencia->status_aprovacao),
            $frequencia->lancadoPor->name ?? '',
            $frequencia->observacao ?? '',
        ];
    }
}
