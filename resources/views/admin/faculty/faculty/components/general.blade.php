<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin khoa</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Tên khoa</label>
            <input type="text" class="form-control" id="name" value="{{ old('name', $faculty->name ?? '') }}" name="name" placeholder="Ví dụ: Khoa Công Nghệ Thông Tin">
            @error('name')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{ $message }}</label>
            @enderror
        </div>
        <div class="form-group">
            <label for="code">Mã khoa</label>
            <input type="text" class="form-control" id="code" value="{{ old('code', $faculty->code ?? '') }}" name="code" placeholder="Ví dụ: CNTT">
            @error('code')
            <label id="code-error" class="error mt-2 text-danger" for="code">{{ $message }}</label>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả về khoa">{{ old('description', $faculty->description ?? '') }}</textarea>
            @error('description')
            <label id="description-error" class="error mt-2 text-danger" for="description">{{ $message }}</label>
            @enderror
        </div>
    </div>
</div>
