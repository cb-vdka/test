<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMajorRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:subjects,code',
            'name' => 'required|string|max:255',
            'credit_num' => 'required|integer|min:1',
            'total_class_session' => 'required|integer|min:1',
            'major_id' => 'required|exists:majors,id',
            'subject_type_id' => 'required|exists:subject_types,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:0,1',
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
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.unique' => 'Mã môn học đã tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'credit_num.required' => 'Số tín chỉ là bắt buộc.',
            'credit_num.integer' => 'Số tín chỉ phải là một số nguyên.',
            'credit_num.min' => 'Số tín chỉ phải lớn hơn hoặc bằng 1.',
            'total_class_session.required' => 'Tổng số buổi học là bắt buộc.',
            'total_class_session.integer' => 'Tổng số buổi học phải là một số nguyên.',
            'total_class_session.min' => 'Tổng số buổi học phải lớn hơn hoặc bằng 1.',
            'major_id.required' => 'Ngành học là bắt buộc.',
            'major_id.exists' => 'Ngành học không hợp lệ.',
            'subject_type_id.required' => 'Hình thức học là bắt buộc.',
            'subject_type_id.exists' => 'Hình thức học không hợp lệ.',
            'course_id.required' => 'Khóa học là bắt buộc.',
            'course_id.exists' => 'Khóa học không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
