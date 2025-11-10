<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
          'nom' => 'required|min:3|string',
          'prenom' => 'required|min:3|string',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|min:6',
        ];

    }
    public function messages(){
      return[
        'nom.required' => 'Le nom est obligatoire.',
        'pernom.required' => 'Le prenom est obligatoire.',
        'email.required' => 'L’email est obligatoire.',
        'email.unique' => 'Cet email existe déjà.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
      ];
    }
}
