<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    @php
        $url = $config['method'] == 'create' ? route('teacher.store') : route('teacher.update', $teacher->id);
        $title = $config['method'] == 'create' ? 'Thêm giảng viên' : 'Chỉnh sửa thông tin giảng viên';
    @endphp

    <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">{{ $title }}</h4>
                <a href="{{ route('teacher.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <form action="{{ $url }}" method="POST" autocomplete="on"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($config['method'] == 'update')
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card custom-border" style="border: 1px solid #ccc">
                                <div class="card-header">
                                    <h5 style="margin: 0">Thông tin giảng viên</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="teacher_name">Tên giảng viên</label>
                                        <input value="{{ old('teacher_name', $teacher->name ?? '') }}" type="text"
                                            class="form-control" id="teacher_name" name="teacher_name"
                                            placeholder="Tên giảng viên">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_email">Email</label>
                                        <input value="{{ old('teacher_email', $teacher->email ?? '') }}" type="email"
                                            class="form-control" id="teacher_email" name="teacher_email"
                                            placeholder="Email giảng viên">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_phone">Số điện thoại</label>
                                        <input value="{{ old('teacher_phone', $teacher->phone ?? '') }}" type="text"
                                            class="form-control" id="teacher_phone" name="teacher_phone"
                                            placeholder="Số điện thoại">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_address">Địa chỉ nhà</label>
                                        <input value="{{ old('teacher_address', $teacher->address ?? '') }}"
                                            type="text" class="form-control" id="teacher_address"
                                            name="teacher_address" placeholder="Địa chỉ nhà">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_current_address">Địa chỉ hiện tại</label>
                                        <input
                                            value="{{ old('teacher_current_address', $teacher->current_address ?? '') }}"
                                            type="text" class="form-control" id="teacher_current_address"
                                            name="teacher_current_address" placeholder="Địa chỉ hiện tại">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_gender">Giới tính</label>
                                        <select class="form-control setupSelect2" id="teacher_gender" name="teacher_gender">
                                            <option value="male"
                                                {{ old('teacher_gender', $teacher->gender ?? '') == 'male' ? 'selected' : '' }}>
                                                Nam</option>
                                            <option value="female"
                                                {{ old('teacher_gender', $teacher->gender ?? '') == 'female' ? 'selected' : '' }}>
                                                Nữ</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_qualifications">Bằng cấp</label>
                                        <input type="text" name="teacher_qualifications" id="teacher_qualifications" class="form-control" value="{{ old('teacher_qualifications', $teacher->qualifications ?? '') }}" placeholder="Nhập bằng cấp">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_date_of_birth">Ngày tháng năm sinh</label>
                                        <input
                                            value="{{ old('teacher_date_of_birth', $teacher->date_of_birth ?? '') }}"
                                            type="date" class="form-control" id="teacher_date_of_birth"
                                            name="teacher_date_of_birth" placeholder="Ngày tháng năm sinh">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_bio">Giới thiệu bản thân</label>
                                        <textarea class="form-control" id="teacher_bio" name="teacher_bio" placeholder="Giới thiệu bản thân">{{ old('teacher_bio', $teacher->bio ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-3 d-flex justify-content-center">
                                @if (old('teacher_image'))
                                    <img src="{{ asset('uploads/teacher/' . old('teacher_image')) }}" alt="Hình ảnh"
                                        width="100" class="rounded-circle img-thumbnail">
                                @elseif(isset($teacher->image))
                                    <img src="{{ asset('uploads/teacher/' . $teacher->image) }}" alt="Hình ảnh"
                                        width="100" class="rounded-circle img-thumbnail">
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="teacher_image">Hình ảnh</label>
                                <input type="file" name="teacher_image" id="teacher_image" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="teacher_cccd_front">Ảnh CCCD (Mặt trước)</label>
                                <input type="file" name="teacher_cccd_front" id="teacher_cccd_front" class="form-control">
                                @if (old('teacher_cccd_front'))
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('uploads/teacher/' . old('teacher_cccd_front')) }}" alt="CCCD Front" width="100" height="100" class="img-thumbnail">
                                    </div>
                                @elseif(isset($teacher->cccd_front))
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('uploads/teacher/' . $teacher->cccd_front) }}" alt="CCCD Front" width="100" height="100" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="teacher_cccd_back">Ảnh CCCD (Mặt sau)</label>
                                <input type="file" name="teacher_cccd_back" id="teacher_cccd_back" class="form-control">
                                @if (old('teacher_cccd_back'))
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('uploads/teacher/' . old('teacher_cccd_back')) }}" alt="CCCD Back" width="100" height="100" class="img-thumbnail">
                                    </div>
                                @elseif(isset($teacher->cccd_back))
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('uploads/teacher/' . $teacher->cccd_back) }}" alt="CCCD Back" width="100" height="100" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="course_id">Chuyên Khoa</label>
                                <select class="form-control setupSelect2" id="course_id" name="course_id">
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $teacher->course_id ?? '') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="major_id">Ngành đào tạo</label>
                                <select class="form-control setupSelect2" id="major_id" name="major_id">
                                    <option value="">Chọn Đối tượng đào tạo</option>
                                    @if(old('course_id') || (isset($teacher->course_id) && $teacher->course_id))
                                        @foreach ($majors as $major)
                                            <option value="{{ $major->id }}"
                                                {{ old('major_id') == $major->id || (isset($teacher->major_id) && $teacher->major_id == $major->id) ? 'selected' : '' }}>
                                                {{ $major->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send"
                                value="send">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#course_id').change(function() {
            var courseId = $(this).val();

            if(courseId) {
                $.ajax({
                    url: '{{ route('teacher.majors.by.course') }}',
                    type: 'GET',
                    data: { course_id: courseId },
                    success: function(data) {
                        $('#major_id').empty();
                        $('#major_id').append('<option value="">Chọn Đối tượng đào tạo</option>');
                        $.each(data, function(key, value) {
                            $('#major_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#major_id').empty();
                $('#major_id').append('<option value="">Chọn Đối tượng đào tạo</option>');
            }
        });
    });

</script>
