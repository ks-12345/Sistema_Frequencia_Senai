<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalisarJustificativaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['secretaria', 'admin'], true);
    }

    public function rules(): array
    {
        return [
            'decisao' => ['required', 'in:aprovar,recusar'],
            'observacao' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
