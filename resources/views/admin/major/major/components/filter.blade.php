<div class="row mb-4">
    <div class="col-sm-12">
        <!-- Bộ lọc -->
        <form method="GET" action="{{ route('major.index') }}" class="row g-3 align-items-center">
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="course_id">
                    <option value="">Chọn đối tượng đào tạo</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="status">
                    <option value="">Chọn trạng thái</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-primary btn-sm me-2">Lọc</button>
                <a href="{{ route('major.index') }}" class="btn btn-secondary btn-sm me-2">Bỏ lọc</a>
                <a href="{{ route('major.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Thêm ngành đào tạo
                </a>
            </div>
        </form>
    </div>
</div>
