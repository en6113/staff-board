<?php

namespace App\Http\Requests;

use App\Enums\PostType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'file_name' => 'nullable|string|max:255',
            'type' => ['required', Rule::enum(PostType::class)],
            'expires_at' => 'nullable|date|after:now',
        ];

        if ($this->isMethod('post')) {
            $rules['file_path'] = 'required|file|max:10240'; // 新規作成時
        } else {
            $rules['file_path'] = 'nullable|file|max:10240'; // 更新時
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'file_path.required' => 'ファイルを添付してください。',
            'type.required' => '区分を選択してください。',
            'expires_at.after' => '現時点より先の日時を指定してください。',
        ];
    }
}
