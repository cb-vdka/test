<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12">
                <!-- Debug info -->
                <div class="alert alert-info">
                    <strong>Debug Info:</strong><br>
                    Số lượng lớp học: {{ $enrollments->count() }}<br>
                    @if(isset($debugInfo))
                        Teacher found: {{ $debugInfo['teacher_found'] ? 'Yes' : 'No' }}<br>
                        Teacher ID: {{ $debugInfo['teacher_id'] ?? 'N/A' }}<br>
                        Teacher Name: {{ $debugInfo['teacher_name'] ?? 'N/A' }}<br>
                        Teacher Email: {{ $debugInfo['teacher_email'] ?? 'N/A' }}<br>
                        Class Subject IDs: {{ implode(', ', $debugInfo['class_subject_ids']) ?: 'None' }}<br>
                        Session User ID: {{ $debugInfo['session_user_id'] ?? 'N/A' }}<br>
                        Session User Email: {{ $debugInfo['session_user_email'] ?? 'N/A' }}<br>
                        Session User Name: {{ $debugInfo['session_user_name'] ?? 'N/A' }}<br>
                    @endif
                    @if($enrollments->count() > 0)
                        Dữ liệu mẫu: {{ $enrollments->first()->classSubject->class->name ?? 'N/A' }} - {{ $enrollments->first()->classSubject->subject->name ?? 'N/A' }} - {{ $enrollments->first()->classSubject->teacher->name ?? 'N/A' }}
                    @else
                        Không có dữ liệu
                    @endif
                </div>
                
                <table id="basic-datatables" class="display table table-striped dataTable" role="grid">
                    <thead>
                        <tr role="row">
                            <th>STT</th>
                            <th>Tên lớp học</th>
                            <th>Môn học</th>
                            <th>Giáo viên</th>
                            <th>Số sinh viên</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($enrollments->count() > 0)
                            @foreach ($enrollments as $index => $item)
                                <tr role="row">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas fa-folder text-primary" style="font-size: 16px;"></i>
                                        <strong>{{ $item->classSubject->class->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $item->classSubject->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $item->classSubject->teacher->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->student_count ?? 0 }} sinh viên</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.enrollment.index', ['class_id' => $item->id]) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Xem bảng điểm
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu lớp học</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
