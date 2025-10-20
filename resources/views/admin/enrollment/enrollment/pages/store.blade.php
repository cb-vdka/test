<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Chỉnh sửa điểm sinh viên</h4>
                <a href="{{ route('enrollment') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <!-- Debug info -->
                <div class="alert alert-warning">
                    <strong>Debug Info:</strong><br>
                    Enrollment ID: {{ $getEdit->id ?? 'NULL' }}<br>
                    Student: {{ $getEdit->student->name ?? 'NULL' }}<br>
                    ClassSubject: {{ $getEdit->class_subject_id ?? 'NULL' }}<br>
                    Current scores: L1={{ $getEdit->lab_1 ?? 'NULL' }}, Final={{ $getEdit->final_exam ?? 'NULL' }}
                </div>
                
                <form action="{{ route('enrollment.update', $getEdit->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin.enrollment.enrollment.components.general')
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send"
                                    value="send">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
