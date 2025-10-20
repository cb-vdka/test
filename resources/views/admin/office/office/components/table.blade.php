<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="basic-datatables_length"></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="basic-datatables_filter" class="dataTables_filter">
                    <form action="{{ route('office.index') }}" method="GET">
                        <label>Tìm kiếm:
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nhập tên hoặc mã phòng" aria-controls="basic-datatables">
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                    <thead>
                    <tr role="row">
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Tên phòng: activate to sort column descending" style="width: 200px;">Tên phòng</th>
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Mã phòng: activate to sort column ascending" style="width: 100px;">Mã phòng</th>
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Trạng thái: activate to sort column ascending" style="width: 100px;">Trạng thái</th>
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Ngày tạo: activate to sort column ascending" style="width: 150px;">Ngày tạo</th>
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Ngày cập nhật: activate to sort column ascending" style="width: 150px;">Ngày cập nhật</th>
                        <th tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Hành động: activate to sort column ascending" style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $office)
                        <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                            <td class="sorting_1">{{ $office->name }}</td>
                            <td>{{ $office->code }}</td>
                            <td>
                                <span class="badge {{ $office->status ? 'badge-success' : 'badge-danger' }}">
                                    {{ $office->status ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td>{{ $office->created_at }}</td>
                            <td>{{ $office->updated_at }}</td>
                            <td>
                                <a href="{{ route('office.edit', ['id' => $office->id]) }}" class="btn btn-sm btn-black" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('office.destroy', ['id' => $office->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
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
                        {{ $data->links('pagination::bootstrap-4') }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
