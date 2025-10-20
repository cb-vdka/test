<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\Enrollments;
use App\Models\ScoreSheet;
use App\Models\PlHdtl1File;
use App\Models\PlHdtl2File;
use App\Models\Teachers;
use App\Models\Account;
use Illuminate\Http\Request;

class EnrollmentStudentController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra role của user
        $userRole = session('user_role');
        $userId = session('user_id');
        
        $query = Enrollments::select(
            'enrollments.*',
            'subjects.name as subject_name',
        )
            ->orderBy('enrollments.created_at', 'DESC')
            ->join('class_subjects', 'enrollments.class_subject_id', '=', 'class_subjects.id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.id');
        
        // Tìm teacher nếu là giáo viên
        $teacher = null;
        if ($userRole == 3 || $userRole == 16) {
            $account = \App\Models\Account::find($userId);
            if ($account) {
                $teacher = \App\Models\Teachers::where('email', $account->email)->first();
                if (!$teacher) {
                    $teacher = \App\Models\Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                }
            }
        }
        
        // Phân quyền hiển thị enrollments
        if ($userRole == 2) {
            // Học viên: chỉ thấy điểm của chính họ
            $query->where('enrollments.student_id', '=', $userId);
        } elseif ($userRole == 3 || $userRole == 16) {
            // Giáo viên: chỉ thấy enrollments của lớp họ dạy (cả public và hidden)
            if ($teacher) {
                $query->whereHas('classSubject', function ($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                });
            } else {
                $query->where('enrollments.id', 0);
            }
        } elseif ($userRole == 1) {
            // Admin: xem tất cả enrollments (không giới hạn theo trạng thái)
            // Không áp dụng filter theo trạng thái phiếu điểm
        }
        
        $getAllEnrollmentStudent = $query->get();
        
        // Đảm bảo $getAllEnrollmentStudent không null
        if (!$getAllEnrollmentStudent) {
            $getAllEnrollmentStudent = collect();
        }
        
        // Lấy danh sách lớp từ database
        $classesQuery = \DB::table('classes')
            ->select('id', 'name')
            ->orderBy('name');
            
        // Nếu là giáo viên, chỉ lấy lớp họ dạy
        if ($userRole == 3 || $userRole == 16) {
            if (isset($teacher) && $teacher && isset($teacher->id)) {
                $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                    ->pluck('class_id')
                    ->toArray();
                    
                if (!empty($classIds)) {
                    $classesQuery->whereIn('id', $classIds);
                } else {
                    // Nếu không có lớp nào, trả về kết quả rỗng
                    $classesQuery->where('id', 0);
                }
            } else {
                // Nếu không tìm thấy teacher, trả về kết quả rỗng
                $classesQuery->where('id', 0);
            }
        }
        
        $classes = $classesQuery->get();
        
        // Đảm bảo $classes không null
        if (!$classes) {
            $classes = collect();
        }
            
        // Lấy danh sách phiếu điểm từ database
        $scoreSheetsQuery = ScoreSheet::with(['class', 'uploadedBy'])
            ->orderBy('created_at', 'DESC');
            
        // Lấy danh sách PL HĐTL1 files từ database
        $plHdtl1FilesQuery = PlHdtl1File::with(['class', 'uploadedBy'])
            ->orderBy('created_at', 'DESC');
            
        // Lấy danh sách PL HĐTL2 files từ database
        $plHdtl2FilesQuery = PlHdtl2File::with(['class', 'uploadedBy'])
            ->orderBy('created_at', 'DESC');
            
        // Phân quyền hiển thị theo trạng thái
        if ($userRole == 3 || $userRole == 16) {
            // Giáo viên: chỉ lấy phiếu điểm của lớp họ dạy (cả public và hidden)
            if ($teacher && isset($teacher->id)) {
                $classIds = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                    ->pluck('class_id')
                    ->toArray();
                    
                if (!empty($classIds)) {
                    $scoreSheetsQuery->whereIn('class_id', $classIds);
                    $plHdtl1FilesQuery->whereIn('class_id', $classIds);
                    $plHdtl2FilesQuery->whereIn('class_id', $classIds);
                } else {
                    // Nếu không có lớp nào, trả về kết quả rỗng
                    $scoreSheetsQuery->where('id', 0);
                    $plHdtl1FilesQuery->where('id', 0);
                    $plHdtl2FilesQuery->where('id', 0);
                }
            } else {
                // Nếu không tìm thấy teacher, trả về kết quả rỗng
                $scoreSheetsQuery->where('id', 0);
                $plHdtl1FilesQuery->where('id', 0);
                $plHdtl2FilesQuery->where('id', 0);
            }
        } elseif ($userRole == 1) {
            // Admin: xem tất cả file (cả public và hidden)
            // Không áp dụng filter theo trạng thái
        } else {
            // Các role khác: không hiển thị gì
            $scoreSheetsQuery->where('id', 0);
            $plHdtl1FilesQuery->where('id', 0);
            $plHdtl2FilesQuery->where('id', 0);
        }
        
        // Lấy tất cả file (không pagination)
        $scoreSheets = $scoreSheetsQuery->get();
        $plHdtl1Files = $plHdtl1FilesQuery->get();
        $plHdtl2Files = $plHdtl2FilesQuery->get();
        
        // Đảm bảo các collections không null
        if (!$scoreSheets) {
            $scoreSheets = collect();
        }
        if (!$plHdtl1Files) {
            $plHdtl1Files = collect();
        }
        if (!$plHdtl2Files) {
            $plHdtl2Files = collect();
        }

        $template = 'admin.enrollment_student.enrollment_student.pages.index';

        return view('admin.dashboard.layout', compact(
            'template',
            'getAllEnrollmentStudent',
            'classes',
            'scoreSheets',
            'plHdtl1Files',
            'plHdtl2Files'
        ));
    }

    public function showSubjectRegister()
    {

        $studentId = session('user_id');
        $enrollments = Enrollments::with(['class.subject', 'class.teacher'])
            ->where('student_id', $studentId)
            ->get();


        $template = 'admin.subject_register.subject_registered.pages.index';

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/subject.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'enrollments'
        ));
    }

    public function destroy($id)
    {
        $enrollment = Enrollments::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('show_subject_register.index')->with('success', 'Ngành học được xóa thành công.');
    }

    public function downloadScoreSheet($id)
    {
        // Tìm score sheet trong database
        $scoreSheet = ScoreSheet::find($id);
        
        if (!$scoreSheet) {
            \Log::error("Score Sheet not found with ID: " . $id);
            return response()->json([
                'success' => false,
                'message' => 'Phiếu điểm không tồn tại!'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $scoreSheet->file_path);
        
        \Log::info("Score Sheet Download attempt:", [
            'file_id' => $id,
            'file_name' => $scoreSheet->file_name,
            'file_path' => $scoreSheet->file_path,
            'full_path' => $filePath,
            'file_exists' => file_exists($filePath)
        ]);
        
        if (!file_exists($filePath)) {
            \Log::error("Score Sheet File not found on server:", [
                'file_path' => $scoreSheet->file_path,
                'full_path' => $filePath
            ]);
            return response()->json([
                'success' => false,
                'message' => 'File không tồn tại trên server!'
            ], 404);
        }
        
        return response()->download($filePath, $scoreSheet->file_name);
    }

    public function updateScoreSheet(Request $request, $id)
    {
        try {
            // Debug: Log request data
            \Log::info('Update request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            // Validation
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            // Tạo tên file mới với timestamp để tránh trùng lặp
            $timestamp = now()->format('Y-m-d_H-i-s');
            $fileName = "Diem_Lop_{$id}_HK1_2024_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/score_sheets/');
            
            // Đảm bảo thư mục tồn tại
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Xóa file cũ nếu tồn tại (tất cả file của lớp này)
            $oldFiles = glob($filePath . "Diem_Lop_{$id}_*");
            foreach ($oldFiles as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                    \Log::info("Deleted old file: " . $oldFile);
                }
            }
            
            // Lưu file mới
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            // Cập nhật thông tin trong database
            $scoreSheet = ScoreSheet::find($id);
            if ($scoreSheet) {
                $scoreSheet->update([
                    'file_name' => $fileName,
                    'file_path' => 'score_sheets/' . $fileName,
                    'file_size' => filesize($fullPath),
                    'file_type' => $file->getClientOriginalExtension(),
                    'status' => $publishImmediately ? 'public' : 'hidden',
                    'updated_at' => now()
                ]);
                
                \Log::info("Score sheet updated in database with ID: " . $scoreSheet->id);
            }
            
            \Log::info("File updated successfully: " . $fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật phiếu điểm thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'publish_immediately' => $publishImmediately
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("Validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error updating score sheet: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function uploadScoreSheet(Request $request)
    {
        try {
            // Debug: Log request data
            \Log::info('Upload request data:', [
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
            $class = \DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $userId = session('user_id');
                $account = Account::find($userId);
                $teacher = null;
                
                if ($account) {
                    $teacher = Teachers::where('email', $account->email)->first();
                    if (!$teacher) {
                        $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                    }
                }
                
                if ($teacher) {
                    $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                        ->where('class_id', $classId)
                        ->exists();
                        
                    if (!$hasPermission) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền upload phiếu điểm cho lớp này!'
                        ], 403);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
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
                    \Log::info("Deleted old file: " . $oldFile);
                }
            }
            
            // Lưu file mới
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            // Lưu thông tin vào database
            $userId = session('user_id');
            
            // Kiểm tra user_id có tồn tại trong database không
            if ($userId && \DB::table('users')->where('id', $userId)->exists()) {
                $uploadedBy = $userId;
            } else {
                $uploadedBy = null; // Nếu user không tồn tại, set null
                \Log::warning("User ID {$userId} not found in users table, setting uploaded_by to null");
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
            
            \Log::info("File uploaded successfully: " . $fullPath);
            \Log::info("Score sheet saved to database with ID: " . $scoreSheet->id);
            
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
            \Log::error("Validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error uploading score sheet: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function toggleStatus(Request $request, $id)
    {
        try {
            $scoreSheet = ScoreSheet::find($id);
            
            if (!$scoreSheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiếu điểm không tồn tại!'
                ], 404);
            }
            
            // Toggle status
            $newStatus = $scoreSheet->status === 'public' ? 'hidden' : 'public';
            $scoreSheet->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            \Log::info("Score sheet status toggled: ID {$id} from {$scoreSheet->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} phiếu điểm thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error toggling score sheet status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deleteScoreSheet($id)
    {
        try {
            $scoreSheet = ScoreSheet::find($id);
            
            if (!$scoreSheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phiếu điểm không tồn tại!'
                ], 404);
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $scoreSheet->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                \Log::info("Deleted file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $scoreSheet->file_name;
            $scoreSheet->delete();
            
            \Log::info("Score sheet deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa phiếu điểm thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error deleting score sheet: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa phiếu điểm: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // PL HĐTL1 Methods
    public function uploadPlHdtl1File(Request $request)
    {
        try {
            \Log::info('PL HĐTL1 Upload request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'class_id' => $request->input('class_id'),
                'file_type' => $request->input('file_type'),
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            $request->validate([
                'file' => 'required|file|max:10240',
                'class_id' => 'required|exists:classes,id',
                'file_type' => 'required|in:kqhttx,kqrl,ngay_cong,dieu_chinh,ren_luyen_kha,hoc_gioi',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $classId = $request->input('class_id');
            $fileType = $request->input('file_type');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $class = \DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $userId = session('user_id');
                $account = Account::find($userId);
                $teacher = null;
                
                if ($account) {
                    $teacher = Teachers::where('email', $account->email)->first();
                    if (!$teacher) {
                        $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                    }
                }
                
                if ($teacher) {
                    $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                        ->where('class_id', $classId)
                        ->exists();
                        
                    if (!$hasPermission) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền upload PL HĐTL1 cho lớp này!'
                        ], 403);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
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
                    \Log::info("Deleted old PL HĐTL1 file: " . $oldFile);
                }
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $userId = session('user_id');
            $uploadedBy = ($userId && \DB::table('users')->where('id', $userId)->exists()) ? $userId : null;
            
            $plHdtl1File = PlHdtl1File::create([
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
            
            \Log::info("PL HĐTL1 file uploaded successfully: " . $fullPath);
            
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
            \Log::error("PL HĐTL1 Validation error: " . $e->getMessage());
            \Log::error("Validation errors: " . json_encode($e->errors()));
            
            $errorMessages = [];
            foreach ($e->errors() as $field => $messages) {
                $errorMessages = array_merge($errorMessages, $messages);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . implode(', ', $errorMessages),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error uploading PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function downloadPlHdtl1File($id)
    {
        $plHdtl1File = PlHdtl1File::find($id);
        
        if (!$plHdtl1File) {
            \Log::error("PL HĐTL1 File not found with ID: " . $id);
            return response()->json([
                'success' => false,
                'message' => 'File PL HĐTL1 không tồn tại!'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $plHdtl1File->file_path);
        
        \Log::info("PL HĐTL1 Download attempt:", [
            'file_id' => $id,
            'file_name' => $plHdtl1File->file_name,
            'file_path' => $plHdtl1File->file_path,
            'full_path' => $filePath,
            'file_exists' => file_exists($filePath)
        ]);
        
        if (!file_exists($filePath)) {
            \Log::error("PL HĐTL1 File not found on server:", [
                'file_path' => $plHdtl1File->file_path,
                'full_path' => $filePath
            ]);
            return response()->json([
                'success' => false,
                'message' => 'File không tồn tại trên server!'
            ], 404);
        }
        
        return response()->download($filePath, $plHdtl1File->file_name);
    }
    
    public function updatePlHdtl1File(Request $request, $id)
    {
        try {
            \Log::info('PL HĐTL1 Update request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

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
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $className = $this->getClassName($plHdtl1File->class);
            $fileName = "PL_HĐTL1_{$className}_{$plHdtl1File->file_type}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl1_files/');
            
            // Xóa file cũ
            $oldFilePath = storage_path('app/public/' . $plHdtl1File->file_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
                \Log::info("Deleted old PL HĐTL1 file: " . $oldFilePath);
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $plHdtl1File->update([
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl1_files/' . $fileName,
                'file_size' => filesize($fullPath),
                'file_extension' => $file->getClientOriginalExtension(),
                'status' => $publishImmediately ? 'public' : 'hidden',
                'updated_at' => now()
            ]);
            
            \Log::info("PL HĐTL1 file updated successfully: " . $fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật file PL HĐTL1 thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'publish_immediately' => $publishImmediately
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("PL HĐTL1 Validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error updating PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function togglePlHdtl1Status(Request $request, $id)
    {
        try {
            $plHdtl1File = PlHdtl1File::find($id);
            
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL1 không tồn tại!'
                ], 404);
            }
            
            $newStatus = $plHdtl1File->status === 'public' ? 'hidden' : 'public';
            $plHdtl1File->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            \Log::info("PL HĐTL1 file status toggled: ID {$id} from {$plHdtl1File->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} file PL HĐTL1 thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error toggling PL HĐTL1 file status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deletePlHdtl1File($id)
    {
        try {
            $plHdtl1File = PlHdtl1File::find($id);
            
            if (!$plHdtl1File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL1 không tồn tại!'
                ], 404);
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $plHdtl1File->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                \Log::info("Deleted PL HĐTL1 file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $plHdtl1File->file_name;
            $plHdtl1File->delete();
            
            \Log::info("PL HĐTL1 file deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa file PL HĐTL1 thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error deleting PL HĐTL1 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // PL HĐTL2 Methods
    public function uploadPlHdtl2File(Request $request)
    {
        try {
            \Log::info('PL HĐTL2 Upload request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'class_id' => $request->input('class_id'),
                'file_type' => $request->input('file_type'),
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

            $request->validate([
                'file' => 'required|file|max:10240',
                'class_id' => 'required|exists:classes,id',
                'file_type' => 'required|in:kq_thi_tn_hang_ngay,kq_thi_tn_dieu_chinh,kq_tot_nghiep,ds_hoc_vien_tn_gioi,ds_hoc_vien_khen_thuong',
                'is_public' => 'nullable'
            ]);
            
            $file = $request->file('file');
            $classId = $request->input('class_id');
            $fileType = $request->input('file_type');
            $publishImmediately = $request->has('is_public') ? $request->boolean('is_public') : false;
            
            $class = \DB::table('classes')->where('id', $classId)->first();
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lớp không tồn tại!'
                ], 404);
            }
            
            // Kiểm tra quyền của giáo viên
            $userRole = session('user_role');
            if ($userRole == 3 || $userRole == 16) {
                $userId = session('user_id');
                $account = Account::find($userId);
                $teacher = null;
                
                if ($account) {
                    $teacher = Teachers::where('email', $account->email)->first();
                    if (!$teacher) {
                        $teacher = Teachers::where('name', 'like', '%' . $account->name . '%')->first();
                    }
                }
                
                if ($teacher) {
                    $hasPermission = \App\Models\ClassSubject::where('teacher_id', $teacher->id)
                        ->where('class_id', $classId)
                        ->exists();
                        
                    if (!$hasPermission) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bạn không có quyền upload PL HĐTL2 cho lớp này!'
                        ], 403);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy thông tin giáo viên!'
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
                    \Log::info("Deleted old PL HĐTL2 file: " . $oldFile);
                }
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $userId = session('user_id');
            $uploadedBy = ($userId && \DB::table('users')->where('id', $userId)->exists()) ? $userId : null;
            
            $plHdtl2File = PlHdtl2File::create([
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
            
            \Log::info("PL HĐTL2 file uploaded successfully: " . $fullPath);
            
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
            \Log::error("PL HĐTL2 Validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error uploading PL HĐTL2 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải lên file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function downloadPlHdtl2File($id)
    {
        $plHdtl2File = PlHdtl2File::find($id);
        
        if (!$plHdtl2File) {
            \Log::error("PL HĐTL2 File not found with ID: " . $id);
            return response()->json([
                'success' => false,
                'message' => 'File PL HĐTL2 không tồn tại!'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $plHdtl2File->file_path);
        
        \Log::info("PL HĐTL2 Download attempt:", [
            'file_id' => $id,
            'file_name' => $plHdtl2File->file_name,
            'file_path' => $plHdtl2File->file_path,
            'full_path' => $filePath,
            'file_exists' => file_exists($filePath)
        ]);
        
        if (!file_exists($filePath)) {
            \Log::error("PL HĐTL2 File not found on server:", [
                'file_path' => $plHdtl2File->file_path,
                'full_path' => $filePath
            ]);
            return response()->json([
                'success' => false,
                'message' => 'File không tồn tại trên server!'
            ], 404);
        }
        
        return response()->download($filePath, $plHdtl2File->file_name);
    }
    
    public function updatePlHdtl2File(Request $request, $id)
    {
        try {
            \Log::info('PL HĐTL2 Update request data:', [
                'file' => $request->hasFile('file') ? 'File present' : 'No file',
                'is_public' => $request->input('is_public'),
                'all_data' => $request->all()
            ]);

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
            
            $timestamp = now()->format('Y-m-d_H-i-s');
            $className = $this->getClassName($plHdtl2File->class);
            $fileName = "PL_HĐTL2_{$className}_{$plHdtl2File->file_type}_{$timestamp}." . $file->getClientOriginalExtension();
            $filePath = storage_path('app/public/pl_hdtl2_files/');
            
            // Xóa file cũ
            $oldFilePath = storage_path('app/public/' . $plHdtl2File->file_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
                \Log::info("Deleted old PL HĐTL2 file: " . $oldFilePath);
            }
            
            $fullPath = $filePath . $fileName;
            $file->move($filePath, $fileName);
            
            $plHdtl2File->update([
                'file_name' => $fileName,
                'file_path' => 'pl_hdtl2_files/' . $fileName,
                'file_size' => filesize($fullPath),
                'file_extension' => $file->getClientOriginalExtension(),
                'status' => $publishImmediately ? 'public' : 'hidden',
                'updated_at' => now()
            ]);
            
            \Log::info("PL HĐTL2 file updated successfully: " . $fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật file PL HĐTL2 thành công! File: ' . $fileName,
                'file_name' => $fileName,
                'file_size' => filesize($fullPath),
                'publish_immediately' => $publishImmediately
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("PL HĐTL2 Validation error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error updating PL HĐTL2 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function togglePlHdtl2Status(Request $request, $id)
    {
        try {
            $plHdtl2File = PlHdtl2File::find($id);
            
            if (!$plHdtl2File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL2 không tồn tại!'
                ], 404);
            }
            
            $newStatus = $plHdtl2File->status === 'public' ? 'hidden' : 'public';
            $plHdtl2File->update(['status' => $newStatus]);
            
            $statusText = $newStatus === 'public' ? 'công khai' : 'tạm ẩn';
            
            \Log::info("PL HĐTL2 file status toggled: ID {$id} from {$plHdtl2File->status} to {$newStatus}");
            
            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} file PL HĐTL2 thành công!",
                'new_status' => $newStatus,
                'status_text' => $newStatus === 'public' ? 'Công khai' : 'Tạm ẩn',
                'badge_class' => $newStatus === 'public' ? 'bg-success' : 'bg-secondary',
                'icon_class' => $newStatus === 'public' ? 'fas fa-eye' : 'fas fa-eye-slash'
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error toggling PL HĐTL2 file status: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deletePlHdtl2File($id)
    {
        try {
            $plHdtl2File = PlHdtl2File::find($id);
            
            if (!$plHdtl2File) {
                return response()->json([
                    'success' => false,
                    'message' => 'File PL HĐTL2 không tồn tại!'
                ], 404);
            }
            
            // Xóa file từ storage
            $filePath = storage_path('app/public/' . $plHdtl2File->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
                \Log::info("Deleted PL HĐTL2 file from storage: " . $filePath);
            }
            
            // Xóa record từ database
            $fileName = $plHdtl2File->file_name;
            $plHdtl2File->delete();
            
            \Log::info("PL HĐTL2 file deleted from database: ID {$id}, File: {$fileName}");
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa file PL HĐTL2 thành công!',
                'deleted_file' => $fileName
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error deleting PL HĐTL2 file: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa file: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper method to safely get class name
     */
    private function getClassName($class)
    {
        if (!$class) {
            return 'UnknownClass';
        }
        
        return $class->name ?? 'UnknownClass';
    }

}