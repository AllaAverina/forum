<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTopicRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['max:255', 'string', 'nullable'],
            'sort' => [
                'string',
                'nullable',
                'in:title,created_at,updated_at,posts_count'
            ],
            'order' => [
                'string',
                'nullable',
                'in:asc,desc'
            ],
        ];
    }
}
