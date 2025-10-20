<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin ban</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Tên ban</label>
            <input type="text" class="form-control" id="name" value="{{ old('name', $division->name ?? '') }}" name="name" placeholder="Ví dụ: Ban Kiểm Tra">
            @error('name')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{ $message }}</label>
            @enderror
        </div>
        <div class="form-group">
            <label for="code">Mã ban</label>
            <input type="text" class="form-control" id="code" value="{{ old('code', $division->code ?? '') }}" name="code" placeholder="Ví dụ: BKT">
            @error('code')
            <label id="code-error" class="error mt-2 text-danger" for="code">{{ $message }}</label>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả về ban">{{ old('description', $division->description ?? '') }}</textarea>
            @error('description')
            <label id="description-error" class="error mt-2 text-danger" for="description">{{ $message }}</label>
            @enderror
        </div>
    </div>
</div>
