<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh Sách Giảng Viên</h4>
                <div class="action">
                    <a href="{{ route('teacher.add') }}" class="btn btn-sm btn-success float-end">
                        <i class="fa fa-plus"></i> Xác thực bằng CCCD
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                        <thead>
                            <tr role="row">
                                <th style="width: 100px;">Tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Số CCCD</th>
                                <th>Quốc tịch</th>
                                <th>Hộ khẩu thường trú</th>
                                <th>Địa chỉ</th>
                                <th>Tỉnh/Thành phố</th>
                                <th>Quận/Huyện</th>
                                <th>Phường/Xã</th>
                                <th>Đường</th>
                                <th>Ngày hết hạn</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userInfos as $userInfo)
                                <tr>
                                    <td>{{ $userInfo->name }}</td>
                                    <td>{{ $userInfo->date_of_birth ? $userInfo->date_of_birth->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $userInfo->gender }}</td>
                                    <td>{{ $userInfo->id_number }}</td>
                                    <td>{{ $userInfo->nationality }}</td>
                                    <td>{{ $userInfo->home }}</td>
                                    <td>{{ $userInfo->address }}</td>
                                    <td>{{ $userInfo->province }}</td>
                                    <td>{{ $userInfo->district }}</td>
                                    <td>{{ $userInfo->ward }}</td>
                                    <td>{{ $userInfo->street }}</td>
                                    <td>{{ $userInfo->doe ? $userInfo->doe->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 10px;">
                                            <a href="{{ route('user-info.show', $userInfo->id) }}" class="btn btn-info btn-sm">Xem</a>
                                            <form action="{{ route('user-info.destroy', $userInfo->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa thông tin này không?')">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
