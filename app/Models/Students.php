<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    public $table = 'students';

    protected $data;

    protected $fillable = [
        'name',
        'student_code',
        'gander',
        'date_of_birth',
        'email',
        'password',
        'address',
        'course_id',
        'major_id',
        'cccd_number',
        'cccd_issue_date',
        'cccd_place',
        'year_of_enrollment',
        'study_status_id',
        'semesters',
        'phone',
        'role_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function getYearOfEnrollmentAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public function getDateOfBirthAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    public function getCccdIssueDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    public function setYearOfEnrollmentAttribute($value)
    {
        $this->attributes['year_of_enrollment'] = \Carbon\Carbon::parse($value);
    }
    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = \Carbon\Carbon::parse($value);
    }
    public function setCccdIssueDateAttribute($value)
    {
        $this->attributes['cccd_issue_date'] = \Carbon\Carbon::parse($value);
    }
    public function getAllStudent($keyword = null, $sort = 10, $major_id)
    {
        $data = Students::with('major:id,name')
            ->orderBy('id', 'DESC');

        if (!empty($keyword)) {
            $data = $data->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%');
        }

        if (!empty($major_id)) {
            $data = $data->where('major_id', '=', $major_id);
        }

        $data = $data->paginate($sort);

        return $data;
    }

    /**
     * Generate password tự động cho học viên
     * Sử dụng số điện thoại làm password
     */
    public static function generatePassword($phone)
    {
        return $phone;
    }

    /**
     * Generate mã học viên tự động
     * Format: AA + số tự tăng (AA12345)
     */
    public static function generateStudentCode()
    {
        // Lấy mã học viên cuối cùng
        $lastStudent = Students::orderBy('id', 'desc')->first();
        
        if ($lastStudent && $lastStudent->student_code) {
            // Extract số từ mã học viên cuối
            $lastCode = $lastStudent->student_code;
            if (preg_match('/^AA(\d+)$/', $lastCode, $matches)) {
                $lastNumber = (int)$matches[1];
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
        } else {
            $newNumber = 1;
        }
        
        return 'AA' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
    public function insertStudent($data)
    {
        return Students::insert($data);
    }
    public function getEditStudent($id)
    {
        $data = Students::find($id);

        return $data;
    }
    public function updateStudent($data, $id)
    {
        $student = Students::find($id);

        return $student->update($data);
    }
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
    public function studystatus()
    {
        return $this->belongsTo(StudyStatus::class);
    }
}