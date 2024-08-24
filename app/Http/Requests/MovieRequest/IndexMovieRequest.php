<?php

namespace App\Http\Requests\MovieRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexMovieRequest extends FormRequest
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
            'page' => ['required', 'integer', 'min:1', 'max:500'],
            'per_page' => ['required', 'integer', 'min:10', 'max:100'],
            'genre_id' => ['nullable', 'integer', 'min:1', 'exists:genres,id'],
            'author_id' => ['nullable', 'integer', 'min:1', 'exists:authors,id'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
