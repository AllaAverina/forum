<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'topic' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
            'title' => [
                'required',
                'max:255',
                Rule::unique('posts')->ignore(optional($this->post)->id),
            ],
            'subtitle' => ['max:255', 'nullable'],
            'body' => ['required'],
        ];
    }
}
