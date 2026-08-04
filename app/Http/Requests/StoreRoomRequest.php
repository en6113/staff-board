<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'グループ名を入力してください',
            'name.max' => 'グループ名は100文字以内で入力してください',
            'member_ids.required' => '参加するメンバーを1人以上選択してください',
            'member_ids.*.exists' => '該当するメンバーが存在しません',
        ];
    }
}
