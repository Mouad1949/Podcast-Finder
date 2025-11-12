<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePodcastRequest extends FormRequest
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
          'catégorie' => 'required|min:4|string',
          'image' => [
                        'required',
                        'image',
                        'mimes:jpg,png,jpeg,gif,svg',
                       ],
        ];

        }
        public function messages(){
          return[
           'title.required' => 'Le title est obligatoire.',
            'title.unique' => 'Le title existe déjà.',
            'description.required' => 'La description est obligatoire.',
            'catégorie.required' => 'La catégorie est obligatoire.',
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'Formats acceptés : jpg, png, jpeg, gif, svg.',
          ];
    }
}
