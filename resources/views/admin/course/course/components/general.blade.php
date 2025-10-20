<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin đối tượng đào tạo</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="course_name">Tên đối tượng đào tạo <span class="text-danger">(*)</span></label>
            <input type="hidden" value="{{ isset($getEdit) ? $getEdit->id : ""}}" name="id"/>
            <input type="text" class="form-control @error('name') border-danger @enderror"" id="course_name"
                name="name" value="{{ isset($getEdit) ? $getEdit->name : old('name') }}" placeholder="Tên đối tượng đào tạo" required>
            @error('name')
                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="training_level">Trình độ đối tượng đào tạo <span class="text-danger">(*)</span></label>
            <select class="form-control @error('training_level') border-danger @enderror" id="training_level" name="training_level" required>
                <option value="">-- Chọn trình độ đào tạo --</option>
                <option value="Trung cấp" {{ (isset($getEdit) && $getEdit->training_level == 'Trung cấp') || old('training_level') == 'Trung cấp' ? 'selected' : '' }}>Trung cấp</option>
                <option value="Cao đẳng" {{ (isset($getEdit) && $getEdit->training_level == 'Cao đẳng') || old('training_level') == 'Cao đẳng' ? 'selected' : '' }}>Cao đẳng</option>
                <option value="Đại học" {{ (isset($getEdit) && $getEdit->training_level == 'Đại học') || old('training_level') == 'Đại học' ? 'selected' : '' }}>Đại học</option>
                <option value="Thạc sĩ" {{ (isset($getEdit) && $getEdit->training_level == 'Thạc sĩ') || old('training_level') == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                <option value="Tiến sĩ" {{ (isset($getEdit) && $getEdit->training_level == 'Tiến sĩ') || old('training_level') == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
            </select>
            @error('training_level')
                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
            @enderror
        </div>
        <!-- <div class="form-group">
            <label for="major_name">Ngành đào tạo <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control @error('major_name') border-danger @enderror" id="major_name"
                name="major_name" value="{{ isset($getEdit) ? $getEdit->major_name : old('major_name') }}" placeholder="Ví dụ: Công nghệ thông tin" required>
            @error('major_name')
                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
            @enderror
        </div> -->
        <div class="form-group">
            <label for="major_code">Mã đối tượng đào tạo <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control @error('major_code') border-danger @enderror" id="major_code"
                name="major_code" value="{{ isset($getEdit) ? $getEdit->major_code : old('major_code') }}" placeholder="Ví dụ: SQDB" required>
            @error('major_code')
                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="course_description">Mô tả đối tượng đào tạo</label>
            <textarea class="form-control" id="description_course" name="description" placeholder="Mô tả đối tượng đào tạo">{{ isset($getEdit) ? $getEdit->description : old('description') }}</textarea>
        </div>
    </div>
</div>
</div>
