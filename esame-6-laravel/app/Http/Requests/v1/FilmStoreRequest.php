<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'idGenere'=>'required|integer',
            'titolo'=>'required|string|max:45',
            'trama'=>'string|max:500',
            'regista'=>'required|max:45|string',
            'durata'=>'required|string|max:10',
            'anno'=>'required|string',
            'voto'=>'required|string|min:1',
            'generi_secondari'=>'string|min:3',
            'path_img'=> 'required|image|mimes:jpeg,pbg,jpg,webp|max:4048',
            'path_video'=> 'required|mimes:mp4,m4v,mov,avi,mkv' 
        ];
    }
}
