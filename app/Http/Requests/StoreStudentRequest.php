<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:students,email|unique:accounts,email',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'gender' => 'required|in:0,1',
            'date_of_birth' => 'required|date',
            'course_id' => 'required|integer|exists:courses,id',
            'major_id' => 'required|integer|exists:majors,id',
            'year_of_enrollment' => 'required|date',
            'semesters' => 'nullable|integer|min:1|max:10',
            'study_status_id' => 'nullable|integer',
            'address' => 'required|string|max:255',
            'cccd_number' => 'required|string|max:20',
            'cccd_issue_date' => 'required|date',
            'cccd_place' => 'required|string|max:255',
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
            'email.unique' => 'Email đã được sử dụng cho tài khoản khác',
            'phone.required' => 'Vui lòng thêm số điện thoại',
            'phone.string' => 'Số điện thoại phải là chuỗi',
            'phone.regex' => 'Số điện thoại phải gồm 10 hoặc 11 số',
            'gender.required' => 'Vui lòng chọn giới tính',
            'gender.in' => 'Giới tính không hợp lệ',
            'date_of_birth.required' => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date' => 'Ngày sinh phải là ngày',
            'major_id.required' => 'Vui lòng chọn chuyên ngành',
            'major_id.integer' => 'Chuyên ngành không tồn tại',
            'major_id.exists' => 'Chuyên ngành không tồn tại',
            'year_of_enrollment.required' => 'Vui lòng thêm năm nhập học',
            'year_of_enrollment.date' => 'Ngày nhập học phải là ngày',
            'semesters.required' => 'Vui lòng nhập số học kỳ',
            'semesters.integer' => 'Số học kỳ phải là số nguyên',
            'semesters.min' => 'Số học kỳ tối thiểu là 1',
            'semesters.max' => 'Số học kỳ tối đa là 10',
            'study_status_id.required' => 'Vui lòng chọn trạng thái học tập',
            'study_status_id.integer' => 'Trạng thái học tập không hợp lệ',
            'study_status_id.exists' => 'Trạng thái học tập không tồn tại',
            'course_id.required' => 'Vui lòng chọn ngành',
            'course_id.integer' => 'Ngành không hợp lệ',
            'course_id.exists' => 'Ngành không tồn tại',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.max' => 'Địa chỉ quá dài',
            'cccd_number.required' => 'Vui lòng nhập số CCCD',
            'cccd_number.max' => 'Số CCCD quá dài',
            'cccd_issue_date.required' => 'Vui lòng nhập ngày cấp CCCD',
            'cccd_issue_date.date' => 'Ngày cấp CCCD phải là ngày',
            'cccd_place.required' => 'Vui lòng nhập nơi cấp CCCD',
            'cccd_place.max' => 'Nơi cấp CCCD quá dài',
        ];
    }
}
