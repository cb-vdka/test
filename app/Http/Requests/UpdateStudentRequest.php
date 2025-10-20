<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $id = session('student_id_session');

        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:students,email,' . $id,
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'major_id' => 'required|integer|exists:majors,id',
            'year_of_enrollment' => 'required|date',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Tên quá dài',
            'email.required' => 'Vui lòng thêm email',
            'email.email' => 'Email sai định dạng',
            'email.max' => 'Email quá dài',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Vui lòng thêm số điện thoại',
            'phone.string' => 'Số điện thoại phải là chuỗi',
            'phone.regex' => 'Số điện thoại phải gồm 10 hoặc 11 số',
            'major_id.required' => 'Vui lòng chọn chuyên ngành',
            'major_id.integer' => 'Chuyên ngành không tồn tại',
            'major_id.exists' => 'Chuyên ngành không tồn tại',
            'year_of_enrollment.required' => 'Vui lòng thêm năm nhập học',
            'year_of_enrollment.date' => 'Ngày nhập học phải là ngày',
        ];
    }
}
