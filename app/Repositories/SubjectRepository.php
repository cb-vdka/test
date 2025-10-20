<?php

namespace App\Repositories;

use App\Models\Base;
use App\Models\Courses;
use App\Models\Major;
use App\Models\Subjects;
use App\Models\SubjectType;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Services
 */

/*Nơi làm chức năng thêm sửa xóa, có thể tái sử bằng cách exstend BaseRepository*/
class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{

    /* Xài chung thì viết hàm bên đây rồi */
    protected $model;

    public function __construct(Subjects $model)
    {
        $this->model = $model;
    }

    public function getSubjectById(int $id = 0)
    {
        return $this->model->select([
            'id',
            'major_id',
            'subject_type_id',
            'course_id',
            'code',
            'name',
            'credit_num',
            'total_class_session',
            'status',
        ])->findOrFail($id);
    }

    public function getMajors()
    {
        return Major::all(); // Lấy tất cả các ngành học
    }

    public function getSubjectTypes()
    {
        return SubjectType::all(); // Lấy tất cả các loại môn học
    }

    public function getCoures()
    {
        return Courses::all(); // Lấy tất cả các khoa/phòng ban
    }

    public function getMajorsByCourse($courseId)
    {
        return Major::where('course_id', $courseId)->get();
    }
}
