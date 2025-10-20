<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12">
                <!-- Debug info -->
                <div class="alert alert-info">
                    <strong>Debug Info:</strong><br>
                    Số lượng lớp học: {{ $enrollments->count() }}<br>
                    @if($enrollments->count() > 0)
                        Dữ liệu mẫu: {{ $enrollments->first()->class->name ?? 'N/A' }} - {{ $enrollments->first()->subject->name ?? 'N/A' }} - {{ $enrollments->first()->teacher->name ?? 'N/A' }}
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
                                        <strong>{{ $item->class->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $item->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $item->teacher->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->student_count ?? 0 }} sinh viên</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('enrollment.index', ['class_id' => $item->id]) }}" 
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
