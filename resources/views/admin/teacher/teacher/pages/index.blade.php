<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách giáo viên</h4>
                <div class="action">
                    <a href="{{ route('teacher.create') }}" class="btn btn-sm btn-success float-end">
                        <i class="fa fa-plus"></i> Thêm giáo viên
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('teacher.index') }}" method="GET" id="filter-form">
                                    <div class="form-row">
                                        <div class="col">
                                            <label for="search">Tìm kiếm:</label>
                                            <input type="search" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Nhập tên hoặc mã giáo viên" aria-controls="basic-datatables">
                                        </div>
                                        <div class="col">
                                            <label>&nbsp;</label>
                                            <div class="btn-group btn-block d-flex" role="group" aria-label="Filter Actions">
                                                <div class="mr-2">
                                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-secondary" onclick="clearFilter()">Xóa Lọc</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="basic-datatables_length">
                                    <!-- Optional: Can be used to set page length if needed -->
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                @if($data->isEmpty())
                                    <div class="alert alert-warning" role="alert">
                                        Không tìm thấy giáo viên nào trong khoảng thời gian này.
                                    </div>
                                @else
                                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 100px;">Hình ảnh</th>
                                                <th style="width: 80px;">Mã</th>
                                                <th style="width: 120px;">Tên</th>
                                                <th style="width: 120px;">Email</th>
                                                <th style="width: 80px;">Phone</th>
                                                <th style="width: 120px;">Địa chỉ</th>
                                                <th style="width: 100px;">Giới tính</th>
                                                <th style="width: 100px;">Ngày sinh</th>
                                                <th style="width: 120px;">Bằng cấp</th>
                                                <th style="width: 100px;">Chuyên khoa</th>
                                                <th style="width: 100px;">Chuyên ngành</th>
                                                <th style="width: 100px;">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $teacher)
                                                <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                                                    <td style="text-align: center;">
                                                        <img src="{{ $teacher->image ? asset('uploads/teacher/' . $teacher->image) : asset('uploads/def/sbcf-default-avatar.webp') }}" 
                                                             alt="Hình ảnh" class="rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                                                    </td>
                                                    <td style="padding: 2px; line-height: 1.2;">{{ $teacher->code }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->name }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->email }}</td>
                                                    <td style="padding: 2px; line-height: 1.2;">{{ $teacher->phone }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->address }}</td>
                                                    <td style="padding: 2px; line-height: 1.2;">{{ $teacher->gender }}</td>
                                                    <td style="padding: 2px; line-height: 1.2;">{{ $teacher->date_of_birth }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->qualifications }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->course->name ?? 'Chưa có' }}</td>
                                                    <td style="padding: 2px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->major->name ?? 'Chưa có' }}</td>
                                                    <td style="padding: 2px; line-height: 1.2;">
                                                        <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-sm btn-black">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giáo viên này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="row">
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
            </div>
        </div>
    </div>
</div>

<script>
    function clearFilter() {
        document.getElementById('search').value = '';
        document.getElementById('filter-form').submit();
    }
</script>

<style>
    #basic-datatables th, #basic-datatables td {
        font-size: 12px; /* Decrease font size */
        padding: 8px; /* Decrease padding */
    }
    #basic-datatables td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
