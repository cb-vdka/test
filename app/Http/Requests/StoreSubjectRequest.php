<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'credit_num' => 'required',
            'total_class_session' => 'required',
            'course_id' => 'required',
            'major_id' => 'required',
            'subject_type_id' => 'required',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Vui lòng nhập mã môn học',
            'name.required' => 'Vui lòng tên môn học',
            'credit_num.required' => 'Vui lòng nhập số tín chỉ',
            'total_class_session.required' => 'Vui lòng nhập ca học',
            'course_id.required' => 'Vui lòng chọn ngành học',
            'major_id.required' => 'Vui lòng chọn chuyên ngành',
            'subject_type_id.required' => 'Vui lòng nhập phương thức học'
        ];
    }
}
