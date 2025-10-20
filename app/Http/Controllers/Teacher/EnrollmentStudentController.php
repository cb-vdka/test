<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Enrollments;
use App\Models\ScoreSheet;
use App\Models\PlHdtl1File;
use App\Models\PlHdtl2File;
use App\Models\Teachers;
use App\Models\Account;

class EnrollmentStudentController extends Controller
{
    public function index(Request $request)
    {
        // Chỉ cho phép role giáo viên
        if (!in_array(session('user_role'), [3, 16], true)) {
            return redirect()->route('dashboard.index');
        }

        $userId = session('user_id');

        // Map Teachers/Account -> Teacher linh hoạt theo session
        $teacher = null;
        // Trường hợp session user_id đang là teachers.id (LoginController set cho role giáo viên)
        $teacher = Teachers::find($userId);
        Log::info('Resolve teacher by session user_id as teachers.id: ' . ($teacher ? $teacher->name : 'Not found'));

        if (!$teacher) {
            // Fallback: session user_id có thể là accounts.id -> ánh xạ qua email/name
            $account = Account::find($userId);
            Log::info('Fallback Account by session user_id: ' . ($account ? $account->name : 'Not found'));
            
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                Log::info('Teacher by email: ' . ($teacher ? $teacher->name : 'Not found'));
                
                if (!$teacher) {
                    $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                    Log::info('Teacher by name: ' . ($teacher ? $teacher->name : 'Not found'));
                }
            }
        }

        // Nhận class_id để hiển thị bảng chi tiết theo lớp
        $selectedClassId = $request->input('class_id');

        // Enrollments cho các lớp giáo viên dạy
        $query = Enrollments::select(
            'enrollments.*',
            'subjects.name as subject_name'
        )
            ->orderBy('enrollments.created_at', 'DESC')
            ->join('class_subjects', 'enrollments.class_subject_id', '=', 'class_subjects.id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.id');

        if ($teacher) {
            $query->whereHas('classSubject', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            });
        } else {
            $query->where('enrollments.id', 0);
        }

        $getAllEnrollmentStudent = $query->get();

        // Danh sách lớp của giáo viên
        $classesQuery = DB::table('classes')->select('id', 'name')->orderBy('name');
        if ($teacher) {
            $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
            Log::info('Teacher ID: ' . $teacher->id . ', Class IDs: ' . json_encode($classIds));
            if (!empty($classIds)) {
                $classesQuery->whereIn('id', $classIds);
            } else {
                $classesQuery->where('id', 0);
            }
        } else {
            $classesQuery->where('id', 0);
        }
        $classes = $classesQuery->get();
        Log::info('Classes for teacher: ' . $classes->count());

        // Phiếu điểm và phụ lục theo lớp giáo viên dạy với pagination
        $scoreSheetsQuery = ScoreSheet::with(['class', 'uploadedBy'])->orderBy('created_at', 'DESC');
        $plHdtl1FilesQuery = PlHdtl1File::with(['class', 'uploadedBy'])->orderBy('created_at', 'DESC');
        $plHdtl2FilesQuery = PlHdtl2File::with(['class', 'uploadedBy'])->orderBy('created_at', 'DESC');

        if ($teacher) {
            $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
            
            // Hiển thị tất cả file của lớp teacher dạy
            
            if (!empty($selectedClassId)) {
                if (in_array((int)$selectedClassId, $classIds, true)) {
                    $scoreSheetsQuery->where('class_id', $selectedClassId);
                    $plHdtl1FilesQuery->where('class_id', $selectedClassId);
                    $plHdtl2FilesQuery->where('class_id', $selectedClassId);
                } else {
                    // nếu class_id không thuộc giáo viên, trả về rỗng cho 3 query
                    $scoreSheetsQuery->where('id', 0);
                    $plHdtl1FilesQuery->where('id', 0);
                    $plHdtl2FilesQuery->where('id', 0);
                }
            } else {
                $scoreSheetsQuery->whereIn('class_id', $classIds);
                $plHdtl1FilesQuery->whereIn('class_id', $classIds);
                $plHdtl2FilesQuery->whereIn('class_id', $classIds);
            }
        } else {
            $scoreSheetsQuery->where('id', 0);
            $plHdtl1FilesQuery->where('id', 0);
            $plHdtl2FilesQuery->where('id', 0);
        }

        // Lấy tất cả file (không pagination cho teacher)
        $scoreSheets = $scoreSheetsQuery->get();
        $plHdtl1Files = $plHdtl1FilesQuery->get();
        $plHdtl2Files = $plHdtl2FilesQuery->get();

        $template = 'teacher.enrollment_student.pages.index';

        return view('teacher.dashboard.layout', compact(
            'template',
            'getAllEnrollmentStudent',
            'classes',
            'scoreSheets',
            'plHdtl1Files',
            'plHdtl2Files',
            'selectedClassId'
        ));
    }

    public function uploadScoreSheet(Request $request)
    {
        try {
            // Debug: Log request data
            Log::info('Teacher Upload request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'class_id' => $request->input('class_id'),
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            // Validation
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'class_id' => 'required|exists:classes,id',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $classId = $request->input('class_id');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            // Lấy thông tin lớp
            $class = DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên (resolve teacher từ session trước)
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $teacher = Teachers::find(session('user_id'));
                if (!$teacher) {
                    $account = Account::find(session('user_id'));
                    if ($account) {
                        $teacher = Teachers::where('email', $account->email)->first();
                        if (!$teacher) {
                            $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                        }
                    }
                }

                if (!$teacher) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
                    ], 403);
                }

                $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                    ->where('class_id', $classId)
                    ->exists();

                if (!$hasPermission) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn không có quyền upload phiếu điểm cho lớp này!'
                    ], 403);
                }
            }
            
            // Tạo tên file mới với timestamp
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "Diem_{$class->name}_HK1_2024_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/score_sheets/');
            
            // Đảm bảo thư mục tồn tại
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Xóa file cũ nếu tồn tại (tất cả file của lớp này)
            $oldFiles = glob($filePath . "Diem_{$class->name}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    Log::info("Deleted old file: " . $oldFile);
                }
            }
            
            // Lưu file mới
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            // Lưu thông tin vào database
            $userId = session('user_id');
            
            // Kiểm tra user_id có tồn tại trong database không
            if ($userId && DB::table('users')->where('id', $userId)->exists()) {
                $uploadedBy = $userId;
            } else {
                $uploadedBy = null; // Nếu user không tồn tại, set null
                Log::warning("User ID {$userId} not found in users table, setting uploaded_by to null");
            }
            
            $scoreSheet = ScoreSheet::create([
                'class_id' => $classId,
                'file_name' => $fileName,
                'file_path' => 'score_sheets/' . $fileName,
                'file_size' => filesize($fullPath),
                'file_type' => $file->getClientOriginalExtension(),
                'status' => $publishImmediately ? 'public' : 'hidden',
                'uploaded_by' => $uploadedBy,
                'description' => 'Phiếu điểm lớp ' . $class->name
            ]);
            
            Log::info("Teacher file uploaded successfully: " . $fullPath);
            Log::info("Score sheet saved to database with ID: " . $scoreSheet->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Tải lên phiếu điểm thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'class_id' => $classId,
                'class_name' => $class->name,
                'publish_immediately' => $publishImmediately,
                'score_sheet_id' => $scoreSheet->id
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Teacher validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error uploading score sheet (Teacher): " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadPlHdtl1File(Request $request)
    {
        try {
            Log::info('Teacher PL HĐTL1 Upload request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'class_id' => $request->input('class_id'),
                'file_type' => $request->input('file_type'),
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            $request->validate([
                'file' => 'required|file|max:10240',
                'class_id' => 'required|exists:classes,id',
                'file_type' => 'required|string|max:50',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $classId = $request->input('class_id');
            $fileType = $request->input('file_type');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $class = DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên (resolve teacher từ session trước)
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $teacher = Teachers::find(session('user_id'));
                if (!$teacher) {
                    $account = Account::find(session('user_id'));
                    if ($account) {
                        $teacher = Teachers::where('email', $account->email)->first();
                        if (!$teacher) {
                            $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                        }
                    }
                }

                if (!$teacher) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
                    ], 403);
                }

                $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                    ->where('class_id', $classId)
                    ->exists();

                if (!$hasPermission) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn không có quyền upload PL HĐTL1 cho lớp này!'
                    ], 403);
                }
            }
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "PL_HĐTL1_{$class->name}_{$fileType}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl1_files/');
            
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Xóa file cũ nếu tồn tại
            $oldFiles = glob($filePath . "PL_HĐTL1_{$class->name}_{$fileType}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    Log::info("Deleted old PL HĐTL1 file: " . $oldFile);
                }
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $userId = session('user_id');
            $uploadedBy = ($userId && DB::table('users')->where('id', $userId)->exists()) ? $userId : null;
            
            $plHdtl1File = \App\Models\PlHdtl1File::create([
                'class_id' => $classId,
                'file_type' => $fileType,
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl1_files/' . $fileName,
                'file_size' => filesize($fullPath),
                'file_extension' => $file->getClientOriginalExtension(),
                'status' => $publishImmediately ? 'public' : 'hidden',
                'uploaded_by' => $uploadedBy,
                'description' => 'PL HĐTL1 - ' . $class->name . ' - ' . $fileType
            ]);
            
            Log::info("Teacher PL HĐTL1 file uploaded successfully: " . $fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Tải lên file PL HĐTL1 thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'class_id' => $classId,
                'class_name' => $class->name,
                'file_type' => $fileType,
                'publish_immediately' => $publishImmediately,
                'file_id' => $plHdtl1File->id
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Teacher PL HĐTL1 validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error uploading PL HĐTL1 file (Teacher): " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file PL HĐTL1: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadPlHdtl2File(Request $request)
    {
        try {
            Log::info('Teacher PL HĐTL2 Upload request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'class_id' => $request->input('class_id'),
                'file_type' => $request->input('file_type'),
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            $request->validate([
                'file' => 'required|file|max:10240',
                'class_id' => 'required|exists:classes,id',
                'file_type' => 'required|string|max:50',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $classId = $request->input('class_id');
            $fileType = $request->input('file_type');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $class = DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên (resolve teacher từ session trước)
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $teacher = Teachers::find(session('user_id'));
                if (!$teacher) {
                    $account = Account::find(session('user_id'));
                    if ($account) {
                        $teacher = Teachers::where('email', $account->email)->first();
                        if (!$teacher) {
                            $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                        }
                    }
                }

                if (!$teacher) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
                    ], 403);
                }

                $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                    ->where('class_id', $classId)
                    ->exists();

                if (!$hasPermission) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn không có quyền upload PL HĐTL2 cho lớp này!'
                    ], 403);
                }
            }
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "PL_HĐTL2_{$class->name}_{$fileType}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl2_files/');
            
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Xóa file cũ nếu tồn tại
            $oldFiles = glob($filePath . "PL_HĐTL2_{$class->name}_{$fileType}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    Log::info("Deleted old PL HĐTL2 file: " . $oldFile);
                }
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $userId = session('user_id');
            $uploadedBy = ($userId && DB::table('users')->where('id', $userId)->exists()) ? $userId : null;
            
            $plHdtl2File = \App\Models\PlHdtl2File::create([
                'class_id' => $classId,
                'file_type' => $fileType,
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl2_files/' . $fileName,
                'file_size' => filesize($fullPath),
                'file_extension' => $file->getClientOriginalExtension(),
                'status' => $publishImmediately ? 'public' : 'hidden',
                'uploaded_by' => $uploadedBy,
                'description' => 'PL HĐTL2 - ' . $class->name . ' - ' . $fileType
            ]);
            
            Log::info("Teacher PL HĐTL2 file uploaded successfully: " . $fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Tải lên file PL HĐTL2 thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'class_id' => $classId,
                'class_name' => $class->name,
                'file_type' => $fileType,
                'publish_immediately' => $publishImmediately,
                'file_id' => $plHdtl2File->id
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Teacher PL HĐTL2 validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error uploading PL HĐTL2 file (Teacher): " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file PL HĐTL2: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== SCORE SHEET MANAGEMENT ====================
    
    public function toggleStatus(Request $request, $id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $scoreSheet = ScoreSheet::find($id);
            
            if (!$scoreSheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiếu điểm không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($scoreSheet->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với phiếu điểm này!'
                        ], 403);
                    }
                }
            }
            
            // Toggle status
            $newStatus = $scoreSheet->status === 'public' ? 'hidden' : 'public';
            $scoreSheet->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            Log::info("Score sheet status toggled: ID {$id} from {$scoreSheet->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} phiếu điểm thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error toggling score sheet status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deleteScoreSheet($id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $scoreSheet = ScoreSheet::find($id);
            
            if (!$scoreSheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiếu điểm không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($scoreSheet->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với phiếu điểm này!'
                        ], 403);
                    }
                }
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $scoreSheet->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info("Deleted file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $scoreSheet->file_name;
            $scoreSheet->delete();
            
            Log::info("Score sheet deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa phiếu điểm thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error deleting score sheet: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa phiếu điểm: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateScoreSheet(Request $request, $id)
    {
        try {
            // Debug: Log request data
            Log::info('Teacher Update request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all(),
                'files' => $request->allFiles()
            ]);

            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            // Validation
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'is_public' => 'nullable'
            ]);
            
            $scoreSheet = ScoreSheet::find($id);
            if (!$scoreSheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiếu điểm không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($scoreSheet->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với phiếu điểm này!'
                        ], 403);
                    }
                }
            }
            
            $file = $request->file('file');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            // Tạo tên file mới với timestamp để tránh trùng lặp
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "Diem_{$scoreSheet->class->name}_HK1_2024_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/score_sheets/');
            
            // Đảm bảo thư mục tồn tại
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Xóa file cũ nếu tồn tại
            $oldFilePath = storage_path('app/public/' . $scoreSheet->file_path);
            Log::info("Old file path: " . $oldFilePath);
            
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
                Log::info("Deleted old file: " . $oldFilePath);
            } else {
                Log::info("Old file not found: " . $oldFilePath);
            }
            
            // Xóa tất cả file cũ của lớp này (để đảm bảo)
            $oldFiles = glob($filePath . "Diem_{$scoreSheet->class->name}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    Log::info("Deleted old file by pattern: " . $oldFile);
                }
            }
            
            // Lưu file mới
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            // Cập nhật database
            $scoreSheet->update([
                'file_name' => $fileName,
                'file_path' => 'score_sheets/' . $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden',
                'updated_at' => now()
            ]);
            
            Log::info("Score sheet updated: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật phiếu điểm thành công! File cũ đã được xóa và thay thế bằng file mới.',
                'file_name' => $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error updating score sheet: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật phiếu điểm: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== PL HĐTL1 MANAGEMENT ====================
    
    public function togglePlHdtl1Status(Request $request, $id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $plHdtl1File = PlHdtl1File::find($id);
            
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL1 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl1File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            $newStatus = $plHdtl1File->status === 'public' ? 'hidden' : 'public';
            $plHdtl1File->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            Log::info("PL HĐTL1 file status toggled: ID {$id} from {$plHdtl1File->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} file PL HĐTL1 thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error toggling PL HĐTL1 file status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deletePlHdtl1File($id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $plHdtl1File = PlHdtl1File::find($id);
            
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL1 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl1File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $plHdtl1File->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info("Deleted PL HĐTL1 file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $plHdtl1File->file_name;
            $plHdtl1File->delete();
            
            Log::info("PL HĐTL1 file deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa file PL HĐTL1 thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error deleting PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePlHdtl1File(Request $request, $id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $request->validate([
                'file' => 'required|file|max:10240',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $plHdtl1File = PlHdtl1File::find($id);
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL1 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl1File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "PL_HĐTL1_{$plHdtl1File->class->name}_{$plHdtl1File->file_type}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl1_files/');
            
            // Xóa file cũ nếu tồn tại
            $oldFilePath = storage_path('app/public/' . $plHdtl1File->file_path);
            Log::info("Old file path: " . $oldFilePath);
            
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
                Log::info("Deleted old PL HĐTL1 file: " . $oldFilePath);
            } else {
                Log::info("Old PL HĐTL1 file not found: " . $oldFilePath);
            }
            
            // Xóa tất cả file cũ của lớp này (để đảm bảo)
            $oldFiles = glob($filePath . "PL_HĐTL1_{$plHdtl1File->class->name}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    Log::info("Deleted old PL HĐTL1 file by pattern: " . $oldFile);
                }
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $plHdtl1File->update([
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl1_files/' . $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden',
                'updated_at' => now()
            ]);
            
            Log::info("PL HĐTL1 file updated: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật file PL HĐTL1 thành công! File cũ đã được xóa và thay thế bằng file mới.',
                'file_name' => $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error updating PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật file: ' . $e->getMessage()
            ], 500);
        }
    }

    // Download PL HĐTL1 File
    public function downloadPlHdtl1File($id)
    {
        try {
            $plHdtl1File = PlHdtl1File::find($id);
            
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền teacher
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl1File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền tải file này!'
                        ], 403);
                    }
                }
            }
            
            $filePath = storage_path('app/public/' . $plHdtl1File->file_path);
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File không tồn tại trên server!'
                ], 404);
            }
            
            return response()->download($filePath, $plHdtl1File->file_name);
            
        } catch (\Exception $e) {
            Log::error("Error downloading PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get PL HĐTL2 table HTML for AJAX reload
     */
    public function getPlHdtl2Table(Request $request)
    {
        $fileType = $request->get('fileType', 'kqtn_hang_ngay');

        // Map Account -> Teacher
        $userId = session('user_id');
        $account = Account::find($userId);
        $teacher = null;
        if ($account) {
            $teacher = Teachers::where('email', $account->email)->first();
            if (!$teacher) {
                $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
            }
        }

        $classes = collect();
        if ($teacher) {
            $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
            if (!empty($classIds)) {
                $classes = DB::table('classes')->whereIn('id', $classIds)->select('id','name')->get();
            }
        }

        $plHdtl2Files = PlHdtl2File::with(['class'])
            ->where('file_type', $fileType)
            ->when(!empty($classIds ?? []), function($q) use ($classIds) {
                $q->whereIn('class_id', $classIds);
            }, function($q) {
                $q->where('id', 0);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $titleMap = [
            'kqtn_hang_ngay' => 'KQ thi TN (hàng ngày)',
            'kqtn_dieu_chinh' => 'KQ thi TN (Điều chỉnh)',
            'kq_tot_nghiep' => 'KQ tốt nghiệp',
            'ds_hoc_vien_tn_gioi' => 'DS Học Viên TN Giỏi',
            'ds_khen_thuong' => 'DS học viên khen thưởng',
        ];
        $title = $titleMap[$fileType] ?? $fileType;

        return view('teacher.enrollment_student.components.pl_hdtl2_table_content', compact('plHdtl2Files','fileType','title','classes'))->render();
    }

    // ==================== PL HĐTL2 MANAGEMENT ====================
    
    public function togglePlHdtl2Status(Request $request, $id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $plHdtl2File = PlHdtl2File::find($id);
            
            if (!$plHdtl2File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL2 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl2File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            $newStatus = $plHdtl2File->status === 'public' ? 'hidden' : 'public';
            $plHdtl2File->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            Log::info("PL HĐTL2 file status toggled: ID {$id} from {$plHdtl2File->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} file PL HĐTL2 thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error toggling PL HĐTL2 file status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deletePlHdtl2File($id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $plHdtl2File = PlHdtl2File::find($id);
            
            if (!$plHdtl2File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL2 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl2File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $plHdtl2File->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info("Deleted PL HĐTL2 file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $plHdtl2File->file_name;
            $plHdtl2File->delete();
            
            Log::info("PL HĐTL2 file deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa file PL HĐTL2 thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error deleting PL HĐTL2 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePlHdtl2File(Request $request, $id)
    {
        try {
            // Kiểm tra quyền teacher
            if (!in_array(session('user_role'), [3, 16], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền thực hiện thao tác này!'
                ], 403);
            }

            $request->validate([
                'file' => 'required|file|max:10240',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $plHdtl2File = PlHdtl2File::find($id);
            if (!$plHdtl2File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL2 không tồn tại!'
                ], 404);
            }

            // Kiểm tra teacher có quyền với lớp này không
            $userId = session('user_id');
            $account = Account::find($userId);
            if ($account) {
                $teacher = Teachers::where('email', $account->email)->first();
                if ($teacher) {
                    $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)->pluck('class_id')->toArray();
                    if (!in_array($plHdtl2File->class_id, $classIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền thao tác với file này!'
                        ], 403);
                    }
                }
            }
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "PL_HĐTL2_{$plHdtl2File->class->name}_{$plHdtl2File->file_type}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl2_files/');
            
            // Xóa file cũ
            $oldFilePath = storage_path('app/public/' . $plHdtl2File->file_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
                Log::info("Deleted old PL HĐTL2 file: " . $oldFilePath);
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $plHdtl2File->update([
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl2_files/' . $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden',
                'updated_at' => now()
            ]);
            
            Log::info("PL HĐTL2 file updated: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật file PL HĐTL2 thành công!',
                'file_name' => $fileName,
                'status' => $publishImmediately ? 'public' : 'hidden'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error updating PL HĐTL2 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật file: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== AJAX TABLE RELOAD METHODS ====================
    
    /**
     * Get PL HĐTL1 table HTML for AJAX reload
     */
    public function getPlHdtl1Table(Request $request)
    {
        $teacherUserId = session('user_id');
        $fileType = $request->get('fileType', 'kqhttx'); // Default to kqhttx
        
        // Lấy danh sách lớp mà giáo viên này dạy
        $teacherClasses = \App\Models\ClassSubject::where('teacher_id', $teacherUserId)
            ->with('class')
            ->get()
            ->pluck('class');
        
        // Lấy danh sách file PL HĐTL1 của các lớp mà giáo viên dạy, filter theo fileType
        $classIds = $teacherClasses->pluck('id')->toArray();
        $plHdtl1Files = PlHdtl1File::whereIn('class_id', $classIds)
            ->where('file_type', $fileType)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Tạo title từ fileType
        $title = $this->getFileTypeTitle($fileType);
        
        return view('teacher.enrollment_student.components.pl_hdtl1_table_content', compact('plHdtl1Files', 'fileType', 'title'))->render();
    }
    
    /**
     * Get file type title from file type
     */
    private function getFileTypeTitle($fileType)
    {
        $titles = [
            'kqhttx' => 'KQHTTX',
            'kqrl' => 'KQRL',
            'ngay_cong' => 'Ngày công học tập',
            'dieu_chinh' => 'Điều chỉnh',
            'ren_luyen_kha' => 'Học viên rèn luyện khá',
            'hoc_gioi' => 'Danh sách học viên học giỏi'
        ];
        
        return $titles[$fileType] ?? 'KQHTTX';
    }

}


