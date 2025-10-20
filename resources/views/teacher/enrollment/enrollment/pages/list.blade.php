<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <!-- Hiển thị danh sách lớp học cho cả admin và giáo viên -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">📊 Danh sách lớp học</h4>
                <div class="float-right">
                    <span class="badge badge-success">Tổng: {{ $enrollments->count() }} lớp học</span>
                </div>
            </div>
            <div class="card-body">
                @include('teacher.enrollment.enrollment.components.list')
            </div>
        </div>
    </div>
</div>
