<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">
                    Danh sách lịch huấn luyện
                    @if (isset($teacherId) && $teacherId)
                        @php
                            $selectedTeacher = $teachers->where('id', $teacherId)->first();
                        @endphp
                        @if ($selectedTeacher)
                            - Giảng viên: {{ $selectedTeacher->name }}
                        @endif
                    @endif
                </h4>

                <div class="action">
                    @if (isset($teacherId) && $teacherId)
                        <span class="badge badge-info mr-2">
                            {{ $getAllTeachingSchedule->count() }} lịch huấn luyện
                        </span>
                    @endif
                    <a href="{{ route('teaching_schedule.create') }}" class="btn btn-sm btn-success mr-2">
                        <i class="fa fa-plus"></i> Thêm lịch huấn luyện
                    </a>
                    <a href="{{ route('teaching_schedule.export') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-file-excel"></i> Xuất Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.teaching_schedule.teaching_schedule.components.calendar')

            </div>
        </div>
    </div>
</div>
