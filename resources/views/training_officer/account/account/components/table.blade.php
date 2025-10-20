<div class="table-responsive">
    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="basic-datatables_length">
                    <label>Hiển thị:
                        <select name="basic-datatables_length" aria-controls="basic-datatables" class="form-control form-control-sm">
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
                    <label>Tìm kiếm:
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="basic-datatables">
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                    <thead>
                        <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Tên cán bộ đào tạo: activate to sort column descending" style="width: 25%;">Tên</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 25%;">Email</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Phòng: activate to sort column ascending" style="width: 16%;">Phòng</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Khoa: activate to sort column ascending" style="width: 16%;">Khoa</th>
                <th class="sorting" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Ban: activate to sort column ascending" style="width: 16%;">Ban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getAllTrainingOfficerAccount as $items)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{ $items->name }}</td>
                                <td>{{ $items->email }}</td>
                                <td>
                                    @if($items->office)
                                        <span class="badge badge-primary">{{ $items->office->name }}</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($items->faculty)
                                        <span class="badge badge-success">{{ $items->faculty->name }}</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($items->division)
                                        <span class="badge badge-warning">{{ $items->division->name }}</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($items->trashed())
                                        <form action="{{ route('training_officer_account.restore', ['id' => $items->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa fa-undo"></i> Phục hồi
                                            </button>
                                        </form>
                                        <form action="{{ route('training_officer_account.forceDelete', ['id' => $items->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn cán bộ đào tạo này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('training_officer_account.edit', ['id' => $items->id]) }}" class="btn btn-sm btn-black">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('training_officer_account.destroy', ['id' => $items->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cán bộ đào tạo này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate">
            <ul class="pagination">
                {{ $getAllTrainingOfficerAccount->links('pagination::bootstrap-5') }}
            </ul>
        </div>
    </div>
</div>

