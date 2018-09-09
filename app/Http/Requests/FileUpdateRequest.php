<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chunk' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (base64_decode($value) === false) {
                        $fail($attribute . ' must be a base64 encoded string');
                    }
                }
            ], // Max request size should be set in php.ini
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'chunk.regex' => 'Chunk must be a base64 encoded string',
        ];
    }
}
