<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        @include('admin.classroom.classroom.components.filter')

        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover table-sm dataTable" role="grid" aria-describedby="basic-datatables_info">
                    <thead>
                    <tr role="row">
                        <th style="width: 200px;">Tên địa điểm học</th>
                        <th style="width: 300px;">Mô tả</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 120px;">Ngày tạo</th>
                        <th style="width: 120px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($data as $item)
                        <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                            <td style="font-size: 14px">{{ $item->name }}</td>
                            <td style="font-size: 14px">{{ $item->description ?? 'Không có mô tả' }}</td>
                            <td style="font-size: 14px">
                                {!! $item->status == 1 ? '<span class="badge badge-success">Hoạt động</span>' : '<span class="badge badge-danger">Không hoạt động</span>' !!}
                            </td>
                            <td style="font-size: 14px">{{ $item->created_at ? $item->created_at->format('d/m/Y') : "Không có dữ liệu" }}</td>
                            <td style="font-size: 14px">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('classroom.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-info" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('classroom.destroy', ['id' => $item->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng học này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-warning" role="alert">
                                    Không tìm thấy dữ liệu.
                                </div>
                            </td>
                        </tr>
                    @endforelse
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