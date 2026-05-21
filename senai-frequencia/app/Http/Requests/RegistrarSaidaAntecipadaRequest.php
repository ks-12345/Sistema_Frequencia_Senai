<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarSaidaAntecipadaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'professor';
    }

    public function rules(): array
    {
        return [
            'turma_id' => ['required', 'exists:turmas,id'],
            'data' => ['required', 'date'],
            'frequencias' => ['required', 'array'],
            'frequencias.*' => ['required', 'in:presente,falta,atraso,saida_antecipada'],
            'observacoes' => ['nullable', 'array'],
            'observacoes.*' => ['nullable', 'string', 'max:500'],
            'saida_horario' => ['nullable', 'array'],
            'saida_horario.*' => ['nullable', 'date_format:H:i'],
            'saida_motivo' => ['nullable', 'array'],
            'saida_motivo.*' => ['nullable', 'string', 'max:1000'],
            'saida_observacoes' => ['nullable', 'array'],
            'saida_observacoes.*' => ['nullable', 'string', 'max:1000'],
            'saida_apresentou_justificativa' => ['nullable', 'array'],
            'saida_apresentou_justificativa.*' => ['nullable', 'boolean'],
            'atraso_horario' => ['nullable', 'array'],
            'atraso_horario.*' => ['nullable', 'date_format:H:i'],
            'atraso_motivo' => ['nullable', 'array'],
            'atraso_motivo.*' => ['nullable', 'string', 'max:1000'],
            'atraso_observacoes' => ['nullable', 'array'],
            'atraso_observacoes.*' => ['nullable', 'string', 'max:1000'],
            'atraso_apresentou_justificativa' => ['nullable', 'array'],
            'atraso_apresentou_justificativa.*' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'saida_horario.*.date_format' => 'Informe o horario de saida no formato correto.',
            'atraso_horario.*.date_format' => 'Informe o horario de entrada no formato correto.',
        ];
    }
}
