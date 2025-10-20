<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin đối tượng đào tạo</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="course_id">Đối tượng đào tạo</label>
            <select class="form-control setupSelect2" id="course_id" name="course_id">
                    <option>--Chọn chuyên ngành--</option>
            @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $major->course_id ?? '') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
            <label id="course_id-error" class="error mt-2 text-danger" for="course_id">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control setupSelect2" id="status" name="status">
                <option value="0" {{ old('status', $major->status ?? '') == 0 ? 'selected' : '' }}>Hoạt động</option>
                <option value="1" {{ old('status', $major->status ?? '') == 1 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('status')
            <label id="status-error" class="error mt-2 text-danger" for="status">{{ $message }}</label>
            @enderror
        </div>
    </div>
</div>


