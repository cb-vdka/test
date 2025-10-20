<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:classrooms,id',
            'school_shift_id' => 'required|exists:school_shifts,id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'day_of_week' => 'required|string|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'class_id.required' => 'Vui lòng chọn lớp',
            'class_id.exists' => 'Lớp không tồn tại',
            'subject_id.required' => 'Vui lòng chọn môn học',
            'subject_id.exists' => 'Môn học không tồn tại',
            'teacher_id.required' => 'Vui lòng chọn giảng viên',
            'teacher_id.exists' => 'Giảng viên không tồn tại',
            'room_id.required' => 'Vui lòng chọn địa điểm học',
            'room_id.exists' => 'Địa điểm học không tồn tại',
            'school_shift_id.required' => 'Vui lòng chọn ca học',
            'school_shift_id.exists' => 'Ca học không tồn tại',
            'schedule_date.required' => 'Vui lòng chọn ngày học',
            'schedule_date.date' => 'Ngày học không đúng định dạng',
            'schedule_date.after_or_equal' => 'Ngày học phải từ hôm nay trở đi',
            'day_of_week.required' => 'Vui lòng chọn thứ trong tuần',
            'day_of_week.max' => 'Thứ trong tuần không được quá 20 ký tự',
        ];
    }
}