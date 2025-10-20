<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin môn học</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="subject_name">Tên môn học</label>
            <input type="text" class="form-control" id="subject_name" value="{{ old('name', $subject->name ?? '') }}" name="name" placeholder="Tên môn học">
        </div>

        <div class="form-group">
            <label for="status">Khóa học</label>
            <select class="form-control setupSelect2" id="course_id" name="course_id">
                <option value="1">Công Nghệ Thông Tin</option>
                <option value="2">Phát Triển Phần Mềm</option>
            </select>
        </div>

        <div class="form-group">
            <label for="instructor">Mô tả</label>
            <textarea name="description" class="form-control" id="description" name="description">{{ old('description', $subject->description ?? '') }}</textarea>
        </div>
    </div>
</div>
