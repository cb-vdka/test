<div class="row mb-4">
    <div class="col-sm-12">
        <!-- Bộ lọc -->
        <form method="GET" action="{{ route('subject.index') }}" class="row g-3 align-items-center">
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="course_id">
                    <option value="">Chọn ngành</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="major_id">
                    <option value="">Chọn chuyên ngành</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select setupSelect2" name="status">
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm" value="{{ request('search') }}">
            </div>

            <div class="col-md-12 d-flex mt-2">
                <div>
                    <button type="submit" class="btn btn-primary btn-sm me-2">Lọc</button>
                    <a href="{{ route('subject.index') }}" class="btn btn-secondary btn-sm me-2">Bỏ lọc</a>
                </div>
                <div>
                    <a href="{{ route('subject.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Thêm môn học
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>