<?php

namespace App\Services;

use App\Models\Subjects;
use App\Repositories\SubjectRepository;
use App\Services\Interfaces\SubjectServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class SubjectService
 * @package App\Services
 */
class SubjectService implements SubjectServiceInterface
{
    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function getSubject($search = null, $courseId = null, $status = null, $majorId = null)
    {
        $query = Subjects::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($majorId) {
            $query->where('major_id', $majorId);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }



    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $requests = $this->subjectRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $this->subjectRepository->update($payload, $id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->subjectRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }
}
