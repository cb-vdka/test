
<style>
    .table thead th {
        border: 1px solid #dee2e6;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        background-color: #f8f9fa;
        padding: 12px 8px;
    }
    .table tbody td {
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;
        padding: 10px 8px;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .student-info {
        text-align: left !important;
    }
</style>

<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

        <div class="row mb-4">
            <div class="col-sm-12">
                @if(request('class_id'))
                    <div class="mb-3">
                        <a href="{{ route('teacher.enrollment.class.list') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Quay lại danh sách lớp học
                        </a>
                    </div>
                @elseif(isset($showScoreTable) && $showScoreTable)
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Chế độ giáo viên:</strong> Hiển thị bảng điểm lớp học của bạn
                        </div>
                    </div>
                @endif
                
                <!-- Bộ lọc -->
                <form method="GET" action="" class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên hoặc MSSV"
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-search"></i> Tìm kiếm
                        </button>
                        @if(request('search'))
                            <a href="{{ request()->url() }}{{ request('class_id') ? '?class_id=' . request('class_id') : '' }}" class="btn btn-secondary btn-sm ms-1">
                                <i class="fa fa-times"></i> Xóa
                            </a>
                        @endif
                    </div>
                    @if(request('class_id'))
                        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                    @endif
                    <div class="col-md-3">
                        @if(request('class_id'))
                            <!-- Truyền class_subject_id hiện tại vào route export -->
                            <a href="{{ route('enrollment.export', ['classId' => request('class_id')]) }}" class="btn btn-info btn-sm me-2"><i class="fa fa-print"></i>
                                Xuất excel</a>
                        @elseif($getAllEnrollment->isNotEmpty())
                            @php
                                $firstClassId = $getAllEnrollment->first()->class_subject_id;
                            @endphp
                            <a href="{{ route('enrollment.export', ['classId' => $firstClassId ?? '']) }}" class="btn btn-info btn-sm me-2"><i class="fa fa-print"></i>
                                Xuất excel</a>
                        @endif
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#uploadExcelModal">
                            Nhập excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!-- Debug info -->
                @if(request('class_id') || (isset($showScoreTable) && $showScoreTable))
                    <div class="alert alert-info">
                        <strong>Thông tin lớp học:</strong><br>
                        @if(request('class_id'))
                            Class ID: {{ request('class_id') }}<br>
                        @endif
                        Số lượng sinh viên: {{ $students->count() ?? 0 }}<br>
                        @if(request('search'))
                            <span class="text-warning">Đang tìm kiếm: "{{ request('search') }}"</span><br>
                        @endif
                        @if(isset($students) && $students instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            Trang {{ $students->currentPage() }} / {{ $students->lastPage() }} (Tổng: {{ $students->total() }} sinh viên)<br>
                            Hiển thị {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} trong {{ $students->total() }} sinh viên<br>
                            Số sinh viên/trang: {{ $students->perPage() }}<br>
                            @if($students->hasPages())
                                <div class="btn-group" role="group">
                                    <a href="{{ $students->previousPageUrl() }}" class="btn btn-sm btn-outline-primary {{ $students->onFirstPage() ? 'disabled' : '' }}">Trước</a>
                                    <a href="{{ $students->nextPageUrl() }}" class="btn btn-sm btn-outline-primary {{ !$students->hasMorePages() ? 'disabled' : '' }}">Sau</a>
                                </div>
                            @endif
                        @endif
                        @if(isset($students) && $students->count() > 0)
                            Lớp: {{ $students->first()->classSubject->class->name ?? 'N/A' }} - 
                            Môn: {{ $students->first()->classSubject->subject->name ?? 'N/A' }} - 
                            Giáo viên: {{ $students->first()->classSubject->teacher->name ?? 'N/A' }}<br>
                            Dữ liệu mẫu: {{ $students->first()->student->name ?? 'N/A' }} - {{ $students->first()->student->student_code ?? 'N/A' }}<br>
                            @php
                                $totalScore = 0;
                                $countScore = 0;
                                $passedCount = 0;
                                $failedCount = 0;
                                $noScoreCount = 0;
                                foreach($students as $student) {
                                    if($student->final_exam) {
                                        $gpa = ($student->lab_1 + $student->lab_2 + $student->assignment_1 + $student->lab_3 + $student->lab_4 + $student->assignment_2 + $student->final_exam) / 7;
                                        $totalScore += $gpa;
                                        $countScore++;
                                        if($gpa >= 5) {
                                            $passedCount++;
                                        } else {
                                            $failedCount++;
                                        }
                                    } else {
                                        $noScoreCount++;
                                    }
                                }
                                $averageScore = $countScore > 0 ? number_format($totalScore / $countScore, 1) : 0;
                            @endphp
                            Điểm trung bình lớp: {{ $averageScore }} ({{ $countScore }} sinh viên có điểm)<br>
                            Kết quả: <span class="text-success">{{ $passedCount }} đậu</span> / <span class="text-danger">{{ $failedCount }} rớt</span> / <span class="text-info">{{ $noScoreCount }} chưa có điểm</span><br>
                            @if($countScore > 0)
                                Tỷ lệ đậu: {{ number_format(($passedCount / $countScore) * 100, 1) }}%
                            @endif<br>
                            Cập nhật lần cuối: {{ $students->first()->updated_at ? $students->first()->updated_at->format('d/m/Y H:i') : 'N/A' }}
                        @else
                            Không có dữ liệu sinh viên
                        @endif
                    </div>
                @endif
                
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                       aria-describedby="basic-datatables_info">
                    <thead>
                    <tr role="row">
                        <th rowspan="2" style="width: 15%;">Thông Tin Sinh Viên</th>
                        <th rowspan="2">Phần Bảng Điểm</th>
                        <th colspan="2">Phụ lục HĐTL 1</th>
                        <th colspan="3">Phụ lục HĐTL 2</th>
                        <th rowspan="2" style="width: 10%;">Ngày Nhập</th>
                        <th rowspan="2">Hành động</th>
                    </tr>
                    <tr role="row">
                        <!-- Phụ lục HĐTL 1 -->
                        <th>KQHTTX</th>
                        <th>KQRL</th>
                        <!-- Phụ lục HĐTL 2 -->
                        <th>KQ thi TN(hàng ngày)</th>
                        <th>KQ thi TN(điều chỉnh)</th>
                        <th>Kết quả tốt nghiệp</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($students) && $students->count() > 0)
                        @foreach ($students as $items)
                        <tr role="row" class="odd">
                            <td class="student-info">
                                <strong>Tên:</strong> {{ $items->student->name ?? '' }}<br>
                                <strong>MSSV:</strong> {{ $items->student->student_code ?? '' }}<br>
                                <strong>Lớp:</strong> {{ $items->classSubject->class->name ?? '' }}
                            </td>
                            <!-- Phần Bảng Điểm -->
                            <td class="sorting_1">
                                <strong>L1:</strong> {{ $items->assignment_1 ?? '' }}<br>
                                <strong>L2:</strong> {{ $items->lab_3 ?? '' }}<br>
                                <strong>L3:</strong> {{ $items->lab_4 ?? '' }}<br>
                                <strong>L4:</strong> {{ $items->assignment_2 ?? '' }}<br>
                                <strong>ASM:</strong> {{ $items->final_exam ?? '' }}
                            </td>
                            <!-- Phụ lục HĐTL 1 -->
                            <td class="sorting_1">{{ $items->lab_1 ?? '' }}</td>
                            <td class="sorting_1">{{ $items->lab_2 ?? '' }}</td>
                            <!-- Phụ lục HĐTL 2 -->
                            <td class="sorting_1">
                                @php
                                    $gpa = !empty($items->final_exam)
                                     ? number_format(
                                         ($items->lab_1 +
                                             $items->lab_2 +
                                             $items->assignment_1 +
                                             $items->lab_3 +
                                             $items->lab_4 +
                                             $items->assignment_2 +
                                             $items->final_exam) / 7,
                                         1,
                                         ',',
                                         '.',
                                     )
                                     : '';
                                @endphp
                                {{ $gpa }}
                            </td>
                            <td class="sorting_1">
                                @if($gpa === null || $gpa === '')
                                    <span class="text-info">Chưa có điểm</span>
                                @elseif($gpa < 5)
                                    <span class="text-danger">Không đạt</span>
                                @elseif($gpa >= 5)
                                    <span class="text-success">Đạt</span>
                                @else
                                    <span class="text-info">Chưa có điểm</span>
                                @endif
                            </td>
                            <td class="sorting_1">
                                @if($gpa === null || $gpa === '')
                                    <span class="text-info">Chưa xét</span>
                                @elseif($gpa < 5)
                                    <span class="text-danger">Không đạt</span>
                                @elseif($gpa >= 5)
                                    <span class="text-success">Đạt</span>
                                @else
                                    <span class="text-info">Chưa xét</span>
                                @endif
                            </td>
                            <td>{{ $items->created_at ? $items->created_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('enrollment.edit', $items->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu sinh viên</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
            <ul class="pagination">
                @if(isset($students) && method_exists($students, 'links'))
                    {{ $students->links('pagination::bootstrap-5') }}
                @elseif(isset($getAllEnrollment) && method_exists($getAllEnrollment, 'links'))
                    {{ $getAllEnrollment->links('pagination::bootstrap-5') }}
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Modal Upload Excel -->
<div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadExcelModalLabel">Nhập dữ liệu bằng file Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                @if(request('class_id'))
                    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                @endif
                <input type="hidden" name="upload_type" id="upload_type" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Chọn file Excel:</label>
                        <input type="file" name="file" class="form-control" id="excel_file" accept=".xlsx,.xls" required>
                        <div class="form-text">
                            <strong>Loại dữ liệu:</strong> <span id="upload_type_text"></span>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <strong>Hướng dẫn:</strong>
                        <ul class="mb-0">
                            <li>File Excel phải có định dạng .xlsx hoặc .xls</li>
                            <li>Cột đầu tiên: MSSV (Mã số sinh viên)</li>
                            <li>Cột thứ hai: Dữ liệu tương ứng với loại đã chọn</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Upload Excel function
function uploadExcel(type) {
    const modal = new bootstrap.Modal(document.getElementById('uploadExcelModal'));
    const uploadTypeInput = document.getElementById('upload_type');
    const uploadTypeText = document.getElementById('upload_type_text');
    
    // Set upload type
    uploadTypeInput.value = type;
    
    // Set display text
    const typeTexts = {
        'ngay_cong': 'Ngày công học tập điều chỉnh',
        'ren_luyen_kha': 'Học viên rèn luyện khá',
        'hoc_gioi': 'Danh sách học viên học giỏi (điều chỉnh)',
        'khen_thuong': 'Danh sách học viên khen thưởng'
    };
    
    uploadTypeText.textContent = typeTexts[type] || type;
    
    modal.show();
}
</script>
