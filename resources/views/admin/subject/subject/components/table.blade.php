<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        @include('admin.subject.subject.components.filter')

        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover table-sm dataTable" role="grid" aria-describedby="basic-datatables_info">
                    <thead>
                    <tr role="row">
                        <th style="width: 100px;">MMH</th>
                        <th style="width: 190px;">Tên ngành</th>
                        <th style="width: 200px;">Chuyên ngành</th>
                        <th style="width: 250px;">Môn học</th>
                        <th style="width: 10px;">STC</th>
                        <th style="width: 10px;">BH</th>
                        <th style="width: 100px;">TT</th>
                        <th style="width: 100px;">Ngày tạo</th>
                        <th style="width: 125px;">Ngày sửa</th>
                        <th style="width: 120px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($data as $item)
                        <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                            <td style="font-size: 14px">{{ $item->code }}</td>
                            <td style="font-size: 14px">{{ $item->course->name ?? "Không có dữ liệu" }}</td>
                            <td style="font-size: 14px">{{ $item->major->name ?? "Không có dữ liệu" }}</td>
                            <td style="font-size: 14px" class="sorting_1">{{ $item->name }}</td>
                            <td style="font-size: 14px">{{ $item->credit_num }}</td>
                            <td style="font-size: 14px">{{ $item->total_class_session }}</td>
                            <td style="font-size: 14px">{!! $item->status === 0 ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Không hoạt động</span>' !!}</td>
                            <td style="font-size: 14px">
                                {{ $item->created_at ? $item->created_at->format('Y-m-d') : 'Không có dữ liệu' }}
                            </td>
                            <td style="font-size: 14px">
                                {{ $item->updated_at ? $item->updated_at->format('Y-m-d') : 'Không có dữ liệu' }}
                            </td>

                            <td style="font-size: 14px">
                                <a href="{{ route('subject.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-black" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('subject.destroy', ['id' => $item->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa môn học này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
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
