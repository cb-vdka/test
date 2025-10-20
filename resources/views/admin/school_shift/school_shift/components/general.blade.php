<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="code">Mã ca học <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code"
                        placeholder="Nhập mã ca học (VD: CA1)" 
                        value="{{ isset($schoolShift) ? $schoolShift->code : old('code') }}" required maxlength="3">
                    @error('code')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Tên ca học <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Nhập tên ca học" 
                        value="{{ isset($schoolShift) ? $schoolShift->name : old('name') }}" required maxlength="50">
                    @error('name')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Nhập mô tả ca học">{{ isset($schoolShift) ? $schoolShift->description : old('description') }}</textarea>
                    @error('description')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_time">Thời gian bắt đầu <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                        value="{{ isset($schoolShift) ? $schoolShift->start_time : old('start_time') }}" required>
                    @error('start_time')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_time">Thời gian kết thúc <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="end_time" name="end_time"
                        value="{{ isset($schoolShift) ? $schoolShift->end_time : old('end_time') }}" required>
                    @error('end_time')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="shift_date">Ngày ca học <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="shift_date" name="shift_date"
                        value="{{ isset($schoolShift) ? $schoolShift->shift_date : old('shift_date') }}" required>
                    @error('shift_date')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="status" name="status" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="1" {{ (isset($schoolShift) && $schoolShift->status == 1) || old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ (isset($schoolShift) && $schoolShift->status == 0) || old('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('status')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
