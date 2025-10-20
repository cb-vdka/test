<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <!-- Bảng học viên đã có trong lớp -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Học viên đã có trong lớp: {{ $class->name }}</h4>
                <span class="badge badge-info">{{ $enrolledStudents->count() }} học viên</span>
            </div>
            <div class="card-body">
                @if($enrolledStudents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã học viên</th>
                                    <th>Họ và tên</th>
                                    <th>Chuyên ngành</th>
                                    <th>Khóa học</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolledStudents as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge badge-primary">{{ $student->student_code }}</span></td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->major->name ?? 'N/A' }}</td>
                                        <td>{{ $student->course->name ?? 'N/A' }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <strong>Thông báo:</strong> Lớp này chưa có học viên nào.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form thêm học viên mới -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Thêm học viên mới vào lớp: {{ $class->name }}</h4>
                <a href="{{ route('class.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <form action="{{ route('class.store_students', $class->id) }}" method="POST" id="addStudentsForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Thông tin lớp:</label>
                                <div class="alert alert-info">
                                    <strong>Lớp:</strong> {{ $class->name }}<br>
                                    <strong>Chuyên ngành:</strong> {{ $class->major->name ?? 'N/A' }}<br>
                                    <strong>Số môn học:</strong> {{ $classSubjects->count() }} môn
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($classSubjects->count() > 0)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Danh sách môn học trong lớp:</label>
                                    <div class="alert alert-secondary">
                                        <strong>Các môn học học viên sẽ được đăng ký:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach($classSubjects as $classSubject)
                                                <li>
                                                    <strong>{{ $classSubject->subject->name ?? 'N/A' }}</strong>
                                                    @if($classSubject->teacher)
                                                        - Giảng viên: {{ $classSubject->teacher->name }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="student_ids">Chọn học viên <span class="text-danger">*</span></label>
                                <select name="student_ids[]" id="student_ids" class="form-control select2" multiple required>
                                    @foreach($availableStudents as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }} - {{ $student->student_code }} 
                                            ({{ $student->major->name ?? 'N/A' }} - {{ $student->course->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_ids')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Lưu ý:</strong> Khi thêm học viên vào lớp, hệ thống sẽ tự động đăng ký học viên cho tất cả các môn học trong lớp đó.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Danh sách học viên được chọn:</label>
                                <div id="selected-students" class="alert alert-success" style="display: none;">
                                    <!-- Danh sách học viên sẽ được hiển thị ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($availableStudents->count() == 0)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Thông báo:</strong> Tất cả học viên đã được đăng ký vào lớp này hoặc chưa có học viên nào trong hệ thống.
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="text-right">
                        @if($availableStudents->count() > 0)
                            <button type="submit" class="btn btn-success mb10" name="send" value="send">
                                <i class="fas fa-plus"></i> Thêm học viên vào lớp
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary mb10" disabled>
                                <i class="fas fa-ban"></i> Không có học viên để thêm
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo Select2
    $('.select2').select2({
        placeholder: 'Chọn học viên...',
        allowClear: true
    });

    // Xử lý khi chọn học viên
    $('#student_ids').on('change', function() {
        var selectedStudents = $('#selected-students');
        var selectedOptions = $(this).find('option:selected');
        
        if (selectedOptions.length > 0) {
            var html = '<h6>Danh sách học viên được chọn (' + selectedOptions.length + ' học viên):</h6><ul>';
            selectedOptions.each(function() {
                html += '<li>' + $(this).text() + '</li>';
            });
            html += '</ul>';
            selectedStudents.html(html).show();
        } else {
            selectedStudents.hide();
        }
    });

    // Validation form
    $('#addStudentsForm').on('submit', function(e) {
        var studentIds = $('#student_ids').val();

        if (!studentIds || studentIds.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một học viên!');
            return false;
        }

        // Confirm trước khi submit
        var confirmMessage = 'Bạn có chắc chắn muốn thêm ' + studentIds.length + ' học viên vào lớp "{{ $class->name }}" không?\n\nHệ thống sẽ tự động đăng ký họ cho tất cả các môn học trong lớp.';
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
