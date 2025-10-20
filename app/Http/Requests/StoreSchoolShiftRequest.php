<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolShiftRequest extends FormRequest
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
            'code' => 'required|string|max:3|unique:school_shifts,code',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'shift_date' => 'required|date',
            'status' => 'required|boolean',
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
            'code.required' => 'Vui lòng nhập mã ca học',
            'code.max' => 'Mã ca học không được quá 3 ký tự',
            'code.unique' => 'Mã ca học đã tồn tại',
            'name.required' => 'Vui lòng nhập tên ca học',
            'name.max' => 'Tên ca học không được quá 50 ký tự',
            'start_time.required' => 'Vui lòng nhập thời gian bắt đầu',
            'start_time.date_format' => 'Thời gian bắt đầu phải có định dạng HH:MM',
            'end_time.required' => 'Vui lòng nhập thời gian kết thúc',
            'end_time.date_format' => 'Thời gian kết thúc phải có định dạng HH:MM',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu',
            'shift_date.required' => 'Vui lòng chọn ngày ca học',
            'shift_date.date' => 'Ngày ca học phải là ngày hợp lệ',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.boolean' => 'Trạng thái không hợp lệ',
        ];
    }
}
