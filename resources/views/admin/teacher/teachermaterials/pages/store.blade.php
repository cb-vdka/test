<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">Thêm tài liệu giảng dạy</h4>
                <div class="action">
                    <a href="{{ route('materials.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
                </div>
            </div>
            
            <div class="card-body">
                <form action="{{ route('teacher.store-materials') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="officer_id">Cán Bộ</label>
                        <select name="officer_id" id="officer_id" class="form-control">
                            @foreach ($officers as $officer)
                                <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="course_id">Course</label>
                        <select name="course_id" id="course_id" class="form-control">
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file_link">Link Drive</label>
                        <input type="url" name="file_link" id="file_link" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
