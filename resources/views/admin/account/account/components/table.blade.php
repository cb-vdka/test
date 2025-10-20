<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="basic-datatables_length">
                    <label>Hiển thị:
                        <select name="sort" onchange="handleRedirect(this)"
                            aria-controls="basic-datatables" class="form-control form-control-sm">
                            <option value="{{ route('account.index') }}?sort=10"
                                {{ request('sort') == 10 ? 'selected' : '' }}>10</option>
                            <option value="{{ route('account.index') }}?sort=25"
                                {{ request('sort') == 25 ? 'selected' : '' }}>25</option>
                            <option value="{{ route('account.index') }}?sort=50"
                                {{ request('sort') == 50 ? 'selected' : '' }}>50</option>
                            <option value="{{ route('account.index') }}?sort=100"
                                {{ request('sort') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        bản ghi
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="basic-datatables_filter" class="dataTables_filter ">
                    <form class="d-flex align-items-center justify-content-end" action="{{ route('account.index') }}">
                        <label>Tìm kiếm:
                            <input type="search" class="form-control form-control-sm" value="{{ request('keyword') }}"
                                name="keyword" placeholder="" aria-controls="basic-datatables">
                        </label>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm ms-2">Lọc</button>
                            <a href="{{ route('account.index') }}" class="btn btn-secondary btn-sm ">Bỏ lọc</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid"
                    aria-describedby="basic-datatables_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Tên thành viên: activate to sort column descending" style="width: 40%;">Tên
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Tên thành viên: activate to sort column descending" style="width: 40%;">
                                Email</th>
                            <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1"
                                colspan="1" aria-label="Hành động: activate to sort column ascending"
                                style="width: 20%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getAllAccount as $items)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{ $items->name }}</td>
                                <td class="sorting_1">{{ $items->email }}</td>
                                <td class="text-center">
                                    @if ($items->deleted_by == null)
                                        <a href="{{ route('account.edit', $items->id) }}" class="btn btn-sm btn-black">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('account.trash', $items->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('account.restore', $items->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-undo-alt"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('account.delete', $items->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">
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
                {{ $getAllAccount->links('pagination::bootstrap-5') }}
            </ul>
        </div>
    </div>
</div>
