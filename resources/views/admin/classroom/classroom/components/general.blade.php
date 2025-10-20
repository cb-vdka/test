<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Tên địa điểm học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Nhập tên địa điểm học (VD: F203, T101)" 
                        value="{{ isset($classroom) ? $classroom->name : old('name') }}" required maxlength="100">
                    @error('name')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="status" name="status" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="1" {{ (isset($classroom) && $classroom->status == 1) || old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ (isset($classroom) && $classroom->status == 0) || old('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('status')
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
                        placeholder="Nhập mô tả địa điểm học">{{ isset($classroom) ? $classroom->description : old('description') }}</textarea>
                    @error('description')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>