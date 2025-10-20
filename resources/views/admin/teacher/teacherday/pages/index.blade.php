<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Số buổi dạy giảng viên</h4>
                <div class="action">
                    <form action="{{ route('export') }}" method="GET" style="display:inline;">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <input type="hidden" name="shift" value="{{ $shift }}">
                        <button type="submit" class="btn btn-sm btn-primary">Xuất Excel</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('teacher.day') }}" method="GET" id="filter-form">
                                    <div class="form-row align-items-end">
                                        <div class="col-md-4 mb-3">
                                            <label for="search">Tìm kiếm:</label>
                                            <input type="search" name="search" id="search" value="{{ $search ?? '' }}"
                                                class="form-control" placeholder="Nhập tên hoặc mã giảng viên"
                                                aria-controls="basic-datatables">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="start_date">Ngày bắt đầu:</label>
                                            <input type="date" name="start_date" id="start_date"
                                                value="{{ $startDate ?? '' }}" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="end_date">Ngày kết thúc:</label>
                                            <input type="date" name="end_date" id="end_date"
                                                value="{{ $endDate ?? '' }}" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="shift">Ca dạy:</label>
                                            <select name="shift" id="shift" class="form-control">
                                                <option value="">Tất cả</option>
                                                <option value="1" {{ $shift == '1' ? 'selected' : '' }}>Ca 1</option>
                                                <option value="2" {{ $shift == '2' ? 'selected' : '' }}>Ca 2</option>
                                                <option value="3" {{ $shift == '3' ? 'selected' : '' }}>Ca 3</option>
                                                <option value="4" {{ $shift == '4' ? 'selected' : '' }}>Ca 4</option>
                                                <option value="5" {{ $shift == '5' ? 'selected' : '' }}>Ca 5</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <div class="btn-group d-flex" role="group" aria-label="Filter Actions">
                                                <button type="submit" class="btn btn-primary flex-fill mr-2">Tìm kiếm</button>
                                                <button type="button" class="btn btn-secondary flex-fill" onclick="clearFilter()">Xóa Lọc</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <script>
                                function clearFilter() {
                                    document.getElementById('search').value = '';
                                    document.getElementById('start_date').value = '';
                                    document.getElementById('end_date').value = '';
                                    document.getElementById('shift').value = '';
                                    document.getElementById('filter-form').submit();
                                }
                            </script>

                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="basic-datatables_length">
                                    <!-- Optional: Can be used to set page length if needed -->
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table id="basic-datatables" class="display table table-striped table-hover dataTable"
                                    role="grid" aria-describedby="basic-datatables_info">
                                    <thead>
                                        <tr>
                                            <th>Mã giảng viên</th>
                                            <th>Tên giảng viên</th>
                                            <th>Số buổi đã dạy</th>
                                            <th>Số ca dạy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teachers as $teacherData)
                                            <tr>
                                                <td>{{ $teacherData->code }}</td>
                                                <td>{{ $teacherData->name }}</td>
                                                <td>{{ $teacherData->total_sessions }}</td>
                                                <td>{{ $teacherData->total_shifts }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
                                    <ul class="pagination">
                                        <!-- Add pagination links here if necessary -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
