<?php

namespace App\Http\Requests\Admin\Class;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
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
            'name' => 'required|string|min:3|unique:classes,name',
            'major_id' => 'required|exists:majors,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên lớp học là bắt buộc.',
            'name.string' => 'Tên lớp học phải là một chuỗi ký tự.',
            'name.min' => 'Tên lớp học phải có ít nhất 3 ký tự.',
            'name.unique' => 'Tên lớp học này đã tồn tại.',
            'major_id.required' => 'Chuyên ngành học là bắt buộc.',
            'major_id.exists' => 'Chuyên ngành học không tồn tại.'
        ];
    }
}
