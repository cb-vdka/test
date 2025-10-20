<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="basic-datatables_length">
                    <label>Hiển thị:
                        <select name="basic-datatables_length" aria-controls="basic-datatables"
                            class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        bản ghi
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="basic-datatables_filter" class="dataTables_filter">
                    <form action="{{ route('teaching_schedule.index') }}" method="get"
                        class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label>Tìm kiếm:</label>
                            <input type="search" class="form-control form-control-sm" value="{{ request('keyword') }}"
                                name="keyword" placeholder="Tìm kiếm..." aria-controls="basic-datatables">
                        </div>
                        <div class="col-md-4">
                            <label>Giáo viên:</label>
                            <select name="teacher_id" class="form-control form-control-sm setupSelect2">
                                <option value="">-- Tất cả giáo viên --</option>
                                @if(isset($teachers))
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} - {{ $teacher->code ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                                <a href="{{ route('teaching_schedule.index') }}" class="btn btn-secondary btn-sm">Bỏ
                                    lọc</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (isset($teacherId) && $teacherId)
            @php
                $selectedTeacher = $teachers->where('id', $teacherId)->first();
            @endphp
            @if ($selectedTeacher)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-user"></i> Thông tin giáo viên được chọn:</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Tên:</strong> {{ $selectedTeacher->name }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Mã:</strong> {{ $selectedTeacher->code ?? 'N/A' }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Email:</strong> {{ $selectedTeacher->email }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Số điện thoại:</strong> {{ $selectedTeacher->phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                    aria-describedby="basic-datatables_info" style="width: 100%; overflow-x: auto;">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Môn: activate to sort column ascending" white-space: nowrap;
                                style="width: 20%;">Môn</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Lớp: activate to sort column ascending" white-space: nowrap;
                                style="width: 20%;">Lớp</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Giảng viên: activate to sort column ascending" white-space:
                                nowrap; style="width: 20%;">Giảng viên</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Thời gian: activate to sort column ascending" white-space:
                                nowrap; style="width: 20%;">Ca Dạy</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Ngày: activate to sort column ascending" white-space: nowrap;
                                style="width: 15%;">Ngày</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Hành động: activate to sort column ascending" white-space:
                                nowrap; style="width: 10%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getAllTeachingSchedule as $item)
                            <tr role="row" class="odd">
                                <td style="white-space: nowrap;">{{ $item->subject_name }}</td>
                                <td style="white-space: nowrap;">{{ $item->class_name }}</td>
                                <td style="white-space: nowrap;">{{ $item->teacher_name ?? 'Chưa xác định' }}</td>
                                <td style="white-space: nowrap;"
                                    title="{{ $item->shift_name ? $item->start_time . ' - ' . $item->end_time : '' }}">
                                    {{ $item->shift_name ?? 'Chưa xác định' }}</td>
                                <td style="white-space: nowrap;">{{ $item->day_of_week }}</td>
                                <td style="white-space: nowrap;">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('teaching_schedule.edit', $item->id) }}"
                                            class="btn btn-sm btn-warning" title="Sửa">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('teaching_schedule.delete', $item->id) }}"
                                            class="btn btn-sm btn-danger" title="Xóa"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa lịch dạy này?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
            <ul class="pagination">
                {{ $getAllTeachingSchedule->links('pagination::bootstrap-5') }}
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo Select2 cho dropdown giáo viên
    $('.setupSelect2').select2({
        placeholder: 'Chọn giáo viên...',
        allowClear: true
    });
</script>
