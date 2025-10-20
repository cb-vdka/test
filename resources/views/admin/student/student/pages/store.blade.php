{{-- <h1>Thêm hoặc sửa người dùng</h1> --}}
<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    @php
        $url =
            $config['method'] == 'create'
                ? route('student.store')
                : route('student.update', session('student_id_session'));
        $title = $config['method'] == 'create' ? 'Thêm học viên' : 'Chỉnh sửa thông tin';
    @endphp

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">{{ $title }}</h4>
                <a href="{{ route('student.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <form action="{{ $url }}" method="POST" autocomplete="on" id="studentForm">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin.student.student.components.general')
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send"
                                value="send">Lưu</button>
                        </div>
                    </div>
                </form>

                <script>
                    // Đơn giản hóa: Chỉ clear form khi có thông báo thành công
                    document.addEventListener('DOMContentLoaded', function() {
                        // Kiểm tra nếu có thông báo thành công
                        if (document.querySelector('.toastr-success') || 
                            document.querySelector('.alert-success')) {
                            // Clear form
                            document.getElementById('studentForm').reset();
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
