<div class="page-inner">
    @include('teacher.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="fas fa-calendar-day me-2"></i>
                    Chi tiết lịch huấn luyện
                </h4>
                <div class="action">
                    <a href="{{ route('teacher.teaching_schedule.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại lịch
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($schedule))
                    <!-- Schedule Header -->
                    <div class="schedule-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1 text-primary">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $schedule->class_name ?? 'Lớp học' }}
                                </h5>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-book me-1"></i>
                                    {{ $schedule->subject_name ?? 'Môn học' }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $schedule->shift_name ?? 'Ca học' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Details -->
                    <div class="schedule-details">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="detail-card mb-3">
                                    <div class="detail-header">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                        <h6 class="mb-0">Thông tin ngày học</h6>
                                    </div>
                                    <div class="detail-content">
                                        <div class="detail-item">
                                            <label>Ngày dạy:</label>
                                            <span class="value">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Thứ trong tuần:</label>
                                            <span class="value">{{ $schedule->day_of_week ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Thời gian:</label>
                                            <span class="value text-primary fw-bold">
                                                {{ $schedule->start_time ?? 'N/A' }} - {{ $schedule->end_time ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="detail-card mb-3">
                                    <div class="detail-header">
                                        <i class="fas fa-chalkboard-teacher text-success"></i>
                                        <h6 class="mb-0">Thông tin giảng dạy</h6>
                                    </div>
                                    <div class="detail-content">
                                        <div class="detail-item">
                                            <label>Giảng viên:</label>
                                            <span class="value">{{ $schedule->teacher_name ?? 'Chưa xác định' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Địa điểm học:</label>
                                            <span class="value">
                                                <i class="fas fa-door-open me-1"></i>
                                                {{ $schedule->room_name ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <label>Ca dạy:</label>
                                            <span class="value">
                                                <span class="badge bg-info">{{ $schedule->shift_name ?? 'N/A' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    @if(isset($schedule->notes) && $schedule->notes)
                        <div class="schedule-notes mt-4">
                            <div class="detail-card">
                                <div class="detail-header">
                                    <i class="fas fa-sticky-note text-warning"></i>
                                    <h6 class="mb-0">Ghi chú</h6>
                                </div>
                                <div class="detail-content">
                                    <p class="mb-0">{{ $schedule->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="text-muted">Không tìm thấy thông tin lịch huấn luyện</h5>
                        <p class="text-muted">Lịch huấn luyện này có thể đã bị xóa hoặc bạn không có quyền xem.</p>
                        <a href="{{ route('teacher.teaching_schedule.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại lịch
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

