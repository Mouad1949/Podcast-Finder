<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEpisodeRequest extends FormRequest
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
          'title' => 'required|min:3|unique:podcasts,title',
          'description' => 'required|string',
          'audio' => 'required|mimes:mp3,wav,ogg'
        ];

        }
        public function messages(){
          return[
           'title.required' => 'Le title est obligatoire.',
            'title.unique' => 'Le title existe déjà.',
            'description.required' => 'La description est obligatoire.',
            'audio.required' => 'L\'audio est obligatoire.',
          ];
    }
}
