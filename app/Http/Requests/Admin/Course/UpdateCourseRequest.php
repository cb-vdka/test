<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
        $courseId = $this->route('id');
        return [
            'name' => 'required|string|max:255|unique:courses,name,' . $courseId,
            'training_level' => 'required|string|in:Trung cấp,Cao đẳng,Đại học,Thạc sĩ,Tiến sĩ',
            'major_name' => 'required|string|max:255',
            'major_code' => 'required|string|max:50|unique:courses,major_code,' . $courseId,
            'description' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng điền tên Đối tượng đào tạo',
            'name.unique' => "Đối tượng đào tạo $this->name đã tồn tại",
            'name.max' => 'Tên Đối tượng đào tạo không được quá 255 ký tự',
            'training_level.required' => 'Vui lòng chọn trình độ đào tạo',
            'training_level.in' => 'Trình độ đào tạo không hợp lệ',
            'major_name.required' => 'Vui lòng điền ngành đào tạo',
            'major_name.max' => 'Ngành đào tạo không được quá 255 ký tự',
            'major_code.required' => 'Vui lòng điền mã ngành',
            'major_code.unique' => 'Mã ngành đã tồn tại',
            'major_code.max' => 'Mã ngành không được quá 50 ký tự'
        ];
    }
}
