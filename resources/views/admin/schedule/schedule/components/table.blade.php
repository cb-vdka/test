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
                    <form action="{{ route('schedule.index') }}" method="get">

                        <label>Tìm kiếm:
                            <input type="search" class="form-control form-control-sm" value="{{ request('keyword') }}"
                                name="keyword" placeholder="" aria-controls="basic-datatables">
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                    </form>
                    </label>
                </div>
            </div>
            <form action="{{ route('schedule.index') }}" method="get"
                class="d-flex flex-wrap align-items-end gap-2 mb-3">
                <div class="form-group">
                    <label for="class_id">Lớp:</label>
                    <select name="class_id" id="class_id" class="form-control form-control-sm">
                        <option value="">Chọn lớp</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_id">Môn học:</label>
                    <select name="subject_id" id="subject_id" class="form-control form-control-sm">
                        <option value="">Chọn môn học</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="teacher_id">Giảng viên:</label>
                    <select name="teacher_id" id="teacher_id" class="form-control form-control-sm">
                        <option value="">Chọn giảng viên</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label for="school_shift_id">Ca học:</label>
                    <select name="school_shift_id" id="school_shift_id" class="form-control form-control-sm">
                        <option value="">Chọn ca học</option>
                        @foreach ($schoolShifts as $school_shift)
                            <option value="{{ $school_shift->id }}">{{ $school_shift->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Lọc</button>
                    <a href="{{ route('schedule.index') }}" class="btn btn-secondary btn-sm mt-2">Bỏ lọc</a>
                </div>
            </form>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                    aria-describedby="basic-datatables_info" style="width: 100%; overflow-x: auto;">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Lớp: activate to sort column ascending"
                                style="width: 150px; white-space: nowrap;">Lớp</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Môn: activate to sort column ascending"
                                style="width: 200px; white-space: nowrap;">Môn học</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Ca học: activate to sort column ascending"
                                style="width: 150px; white-space: nowrap;">Ca học</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Thời gian: activate to sort column ascending"
                                style="width: 150px; white-space: nowrap;">Thời gian</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Phòng: activate to sort column ascending"
                                style="width: 100px; white-space: nowrap;">Phòng</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Ngày: activate to sort column ascending"
                                style="width: 120px; white-space: nowrap;">Ngày học</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Giảng viên: activate to sort column ascending"
                                style="width: 150px; white-space: nowrap;">Giảng viên</th>
                            @if (session('user_role') == 1)
                                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                    colspan="1" aria-label="Chi tiết: activate to sort column ascending"
                                    style="width: 100px; white-space: nowrap;">Hành động</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($data) && $data->count() > 0)
                            @foreach ($data as $schedule)
                                <tr role="row" class="odd">
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->class->name ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->subject->name ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->schoolShift->name ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->schoolShift->start_time ?? 'N/A' }} -
                                        {{ $schedule->schoolShift->end_time ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->room->name ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @if ($schedule->schedule_date)
                                            {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}
                                            <br><small class="text-muted">({{ $schedule->day_of_week }})</small>
                                        @else
                                            {{ $schedule->day_of_week }}
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $schedule->teacher->name ?? 'N/A' }}
                                        @if ($schedule->teacher && $schedule->teacher->code)
                                            <br><small class="text-muted">({{ $schedule->teacher->code }})</small>
                                        @endif
                                    </td>
                                    @if (session('user_role') == 1)
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('schedule.edit', $schedule->id) }}"
                                                    class="btn btn-sm btn-info" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('schedule.destroy', $schedule->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Xóa"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa lịch huấn luyện này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="basic-datatables_info" role="status" aria-live="polite">Hiển thị 1
                    đến 10 của 20 lịch huấn luyện</div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
                    <ul class="pagination">
                        {{ $data->links('pagination::bootstrap-4') }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
