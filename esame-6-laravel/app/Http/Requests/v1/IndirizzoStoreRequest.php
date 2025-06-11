<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class indirizzoStoreRequest extends FormRequest
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
            "idTipologiaIndirizzo"=>'required|integer',
            "idNazione"=>'required|integer',
            'idComune'=>'required|integer',
            "indirizzo"=>'required|string|max:45',
            "civico"=>'required|string|max:10',
            "cap"=>'required|string|max:10',
            "località"=>'required|string|max:10',
            "provincia"=>"required|string|min:2|max:2"
        ];
    }
}
