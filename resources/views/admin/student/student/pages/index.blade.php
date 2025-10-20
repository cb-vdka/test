<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    {{-- Hiển thị thông tin đăng nhập nếu vừa tạo học viên mới --}}
    @if(session('new_student_login_info'))
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h5><i class="fa fa-info-circle"></i> Thông tin đăng nhập cho học viên mới:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tên học viên:</strong> {{ session('new_student_login_info.name') }}<br>
                        <strong>Mã học viên:</strong> <code>{{ session('new_student_login_info.student_code') }}</code><br>
                        <strong>Email:</strong> {{ session('new_student_login_info.email') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mật khẩu:</strong> <code>{{ session('new_student_login_info.password') }}</code><br>
                        <small class="text-muted">Mật khẩu là số điện thoại của học viên</small><br>
                        <small class="text-muted">Vui lòng ghi lại thông tin này để cung cấp cho học viên!</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @php
            session()->forget('new_student_login_info');
        @endphp
    @endif

    {{-- Phần giao diện được thay đổi  --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Danh sách học viên</h4>
                <!-- Thêm nút thêm mới học viên -->
                <a href="{{ route('student.create') }}" class="btn btn-sm btn-primary float-right">Thêm mới học viên</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_length" id="basic-datatables_length"><label>Hiển thị:
                                        <select name="sort" onchange="handleRedirect(this)"
                                            aria-controls="basic-datatables" class="form-control form-control-sm">
                                            <option value="{{ route('student.index') }}?sort=10"
                                                {{ request('sort') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="{{ route('student.index') }}?sort=25"
                                                {{ request('sort') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="{{ route('student.index') }}?sort=50"
                                                {{ request('sort') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="{{ route('student.index') }}?sort=100"
                                                {{ request('sort') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                </div>
                            </div>
                            @include('admin.student.student.components.filter')
                            @include('admin.student.student.components.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function handleRedirect(select) {
            const value = select.value;
            if (value) {
                window.location.href = value;
            }
        }
    </script>
