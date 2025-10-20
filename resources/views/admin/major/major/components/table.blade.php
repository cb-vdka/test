<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            @include('admin.major.major.components.filter')
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                       aria-describedby="basic-datatables_info">
                    <thead>
                    <tr role="row">
                        <th  style="width: 150px;">
                            Đối tượng đào tạo
                        </th>
                        <th  style="width: 150px;">
                            Mã ngành đào tạo
                        </th> 
                        <th  style="width: 200px;">
                            Ngành đào tạo
                        </th>
                        <th  style="width: 150px;">
                            Tiêu chuẩn
                        </th>
                        <th  style="width: 100px;">
                            Trạng thái
                        </th>
                        <th  style="width: 100px;">
                            Ngày tạo
                        </th>
                        <th  style="width: 100px;">
                            Ngày sửa
                        </th>
                        <th  style="width: 150px;">
                            Hành động
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($data as $item)
                        <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                            <td>{{ $item->course->name ?? "Không có dữ liệu"}}</td>    
                            <td>{{ $item->code ?? "Không có dữ liệu" }}</td>
                            <td>{{ $item->name ?? "Không có dữ liệu"}}</td>
                            <td>{{ $item->standard ?? "Không có dữ liệu"}}</td>
                            <td>{!! $item->status === 0 ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Không hoạt động</span>' !!}</td>
                            <td style="font-size: 14px">
                                {{ $item->created_at ? $item->created_at->format('Y-m-d') : 'Không có dữ liệu' }}
                            </td>
                            <td style="font-size: 14px">
                                {{ $item->updated_at ? $item->updated_at->format('Y-m-d') : 'Không có dữ liệu' }}
                            </td>

                            <td>
                                <a href="{{ route('major.edit', ['id' => $item->id]) }}"
                                   class="btn btn-sm btn-black" title="Sửa">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('major.destroy', ['id' => $item->id]) }}" method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa Đối tượng đào tạo này?');">
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
                    <!-- Các dòng dữ liệu ngành học khác -->
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
