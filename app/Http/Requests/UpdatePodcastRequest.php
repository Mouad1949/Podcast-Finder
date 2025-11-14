<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePodcastRequest extends FormRequest
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
              'title' => 'min:3|unique:podcasts,title',
          'description' => 'string',
          'catégorie' => 'min:4|string',
          'image' => [
                        'image',
                        'mimes:jpg,png,jpeg,gif,svg',
                       ],
        ];
        
    }
}
