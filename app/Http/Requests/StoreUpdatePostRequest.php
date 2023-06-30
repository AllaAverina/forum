<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdatePostRequest extends FormRequest
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
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore(optional($this->post)->id),
            ],
            'subtitle' => ['max:255', 'string', 'nullable'],
            'body' => ['required', 'string',],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'topic_id' => 'topic',
        ];
    }
}
