<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $teacherId = $this->route('teacher'); // Lấy ID giáo viên từ URL (nếu có)
    
        $rules = [
            'teacher_name' => 'required|string|max:255',
            'teacher_phone' => 'required|string|max:20',
            'teacher_address' => 'required|string|max:255',
            'teacher_current_address' => 'required|string|max:255',
            'teacher_gender' => 'required|in:male,female',
            'teacher_date_of_birth' => 'required|date',
            'teacher_bio' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'major_id' => 'required|exists:majors,id',
            'teacher_qualifications' => 'nullable|string',
            'teacher_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'teacher_cccd_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'teacher_cccd_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        if ($this->isMethod('post')) {
            $rules['teacher_email'] = 'required|email|unique:teachers,email';
        }
    
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['teacher_email'] = 'required|email|unique:teachers,email,' . $teacherId;
        }
    
        return $rules;
    }
    

    public function messages()
    {
        return [
            'teacher_name.required' => 'Tên giáo viên là bắt buộc.',
            'teacher_email.required' => 'Email giáo viên là bắt buộc.',
            'teacher_email.email' => 'Email giáo viên phải là địa chỉ email hợp lệ.',
            'teacher_email.unique' => 'Email giáo viên đã tồn tại.',
            'teacher_phone.required' => 'Số điện thoại giáo viên là bắt buộc.',
            'teacher_address.required' => 'Địa chỉ nhà giáo viên là bắt buộc.',
            'teacher_current_address.required' => 'Địa chỉ hiện tại của giáo viên là bắt buộc.',
            'teacher_gender.required' => 'Giới tính giáo viên là bắt buộc.',
            'teacher_gender.in' => 'Giới tính giáo viên phải là nam hoặc nữ.',
            'teacher_date_of_birth.required' => 'Ngày sinh của giáo viên là bắt buộc.',
            'teacher_date_of_birth.date' => 'Ngày sinh của giáo viên phải là một ngày hợp lệ.',
            'course_id.required' => 'Khóa học là bắt buộc.',
            'course_id.exists' => 'Khóa học không hợp lệ.',
            'major_id.required' => 'Chuyên ngành là bắt buộc.',
            'major_id.exists' => 'Chuyên ngành không hợp lệ.',
            'teacher_image.image' => 'Hình ảnh phải là một tập tin ảnh.',
            'teacher_image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'teacher_image.max' => 'Kích thước hình ảnh không được vượt quá 2048 kilobytes.',
            'teacher_cccd_front.image' => 'Ảnh CCCD mặt trước phải là một tập tin ảnh.',
            'teacher_cccd_front.mimes' => 'Ảnh CCCD mặt trước phải có định dạng: jpeg, png, jpg, gif, svg.',
            'teacher_cccd_front.max' => 'Kích thước ảnh CCCD mặt trước không được vượt quá 2048 kilobytes.',
            'teacher_cccd_back.image' => 'Ảnh CCCD mặt sau phải là một tập tin ảnh.',
            'teacher_cccd_back.mimes' => 'Ảnh CCCD mặt sau phải có định dạng: jpeg, png, jpg, gif, svg.',
            'teacher_cccd_back.max' => 'Kích thước ảnh CCCD mặt sau không được vượt quá 2048 kilobytes.',
        ];
    }
}
