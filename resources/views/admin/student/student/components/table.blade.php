<div class="row">
    <div class="col-sm-12">
        <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
               aria-describedby="basic-datatables_info">
            <thead>
            <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                    style="width: 242.312px;">Tên</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-label="Position: activate to sort column ascending" style="width: 366.031px;">email</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-label="Office: activate to sort column ascending" style="width: 187.375px;">Số điện thoại
                </th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-label="Age: activate to sort column ascending" style="width: 84.3125px;">Chuyên ngành</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-label="Start date: activate to sort column ascending" style="width: 183.922px;">Ngày nhập
                    học</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1"
                    aria-label="Salary: activate to sort column ascending" style="width: 156.047px;">Hành động</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($getAllStudent as $student)
                <tr role="row" class="odd">
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->major->name }}</td>
                    <td>{{ $student->year_of_enrollment }}</td>
                    <td class="text-center">
                        @if ($student->deleted_by == null)
                            <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-black">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('student.trash', $student->id) }}" method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i></button>
                            </form>
                        @else
                            <form action="{{ route('student.restore', $student->id) }}" method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                            </form>
                            <form action="{{ route('student.delete', $student->id) }}" method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa học viên này?')">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">
                        <div class="alert alert-warning mb-0" role="alert">
                            Không tìm thấy dữ liệu.
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
    <ul class="pagination">
        {{ $getAllStudent->links('pagination::bootstrap-5') }}
    </ul>
</div>