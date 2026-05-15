<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJustificativaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'aluno';
    }

    public function rules(): array
    {
        return [
            'solicitacao_saida_id' => ['required', 'exists:solicitacoes_saida,id'],
            'descricao' => ['required', 'string', 'max:2000'],
            'arquivo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
