<?php

namespace App\Http\Requests;

use App\Enums\NewsPriority;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'priority' => ['nullable', Rule::enum(NewsPriority::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'content.required' => '内容を入力してください。',
        ];
    }
}