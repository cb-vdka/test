<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $teacherId = $this->route('teacher'); // Lấy ID giáo viên từ URL

        return [
            'teacher_name' => 'required|string|max:255',
       
            'teacher_phone' => 'required|string|max:15',
            'teacher_address' => 'required|string|max:255',
            'teacher_current_address' => 'required|string|max:255',
            'teacher_gender' => 'required|in:male,female',
            'teacher_date_of_birth' => 'required|date',
            'teacher_bio' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'major_id' => 'required|exists:majors,id',
            'teacher_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'teacher_cccd_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'teacher_cccd_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'teacher_name.required' => 'Tên giảng viên là bắt buộc.',
            'teacher_email.email' => 'Email không đúng định dạng.',
            'teacher_email.unique' => 'Email này đã được sử dụng.',
            'teacher_phone.required' => 'Số điện thoại là bắt buộc.',
            'teacher_address.required' => 'Địa chỉ nhà là bắt buộc.',
            'teacher_current_address.required' => 'Địa chỉ hiện tại là bắt buộc.',
            'teacher_gender.required' => 'Giới tính là bắt buộc.',
            'teacher_date_of_birth.required' => 'Ngày tháng năm sinh là bắt buộc.',
            'course_id.required' => 'Chuyên Khoa là bắt buộc.',
            'course_id.exists' => 'Chuyên Khoa không tồn tại.',
            'major_id.required' => 'Chuyên Ngành là bắt buộc.',
            'major_id.exists' => 'Chuyên Ngành không tồn tại.',
            'teacher_image.image' => 'File tải lên phải là hình ảnh.',
            'teacher_image.mimes' => 'File tải lên phải có định dạng jpeg, png, jpg, gif, svg.',
            'teacher_image.max' => 'Kích thước file tải lên không được vượt quá 2MB.',
            'teacher_cccd_front.image' => 'File tải lên phải là hình ảnh.',
            'teacher_cccd_front.mimes' => 'File tải lên phải có định dạng jpeg, png, jpg, gif, svg.',
            'teacher_cccd_front.max' => 'Kích thước file tải lên không được vượt quá 2MB.',
            'teacher_cccd_back.image' => 'File tải lên phải là hình ảnh.',
            'teacher_cccd_back.mimes' => 'File tải lên phải có định dạng jpeg, png, jpg, gif, svg.',
            'teacher_cccd_back.max' => 'Kích thước file tải lên không được vượt quá 2MB.',
        ];
    }
}
