<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin bắt buộc</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="code">Mã ngành đào tạo</label>
            <input type="text" class="form-control" id="code" value="{{ old('code', $major->code ?? '') }}" name="code" placeholder="Ví dụ: D860230">
            @error('code')
            <label id="code-error" class="error mt-2 text-danger" for="code">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">Tên ngành đào tạo</label>
            <input type="text" class="form-control" id="name" value="{{ old('name', $major->name ?? '') }}" name="name" placeholder="Ví dụ: Quân sự cơ sở">
            @error('name')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="standard">Tiêu chuẩn</label>
            <input type="text" class="form-control" id="standard" value="{{ old('standard', $major->standard ?? '') }}" name="standard" placeholder="Ví dụ: Chương trình đào tạo 3 năm">
            @error('standard')
            <label id="standard-error" class="error mt-2 text-danger" for="standard">{{ $message }}</label>
            @enderror
        </div>

    </div>
</div>