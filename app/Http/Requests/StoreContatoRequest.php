<?php

namespace App\Http\Requests;

use App\ContatoTipoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => ['required', Rule::enum(ContatoTipoEnum::class)],
            'informacao' => ['required', 'string']
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute é obrigatório',
            'string' => ':attribute deve ser uma string',
            'enum' => ':attribute não é uma opção válida',
        ];
    }
    public function attributes(): array
    {
        return [
            'tipo' => 'O Tipo',
            'informacao' => 'O Contato'
        ];
    }
}
