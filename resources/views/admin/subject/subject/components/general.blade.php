<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin bắt buộc</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="code">Mã môn học</label>
            <input type="text" class="form-control" id="code" value="{{ old('code', $subject->code ?? '') }}"
                   name="code" placeholder="Ví dụ: CS101">
            @error('code')
            <label id="code-error" class="error mt-2 text-danger" for="code">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">Tên môn học</label>
            <input type="text" class="form-control" id="name" value="{{ old('name', $subject->name ?? '') }}"
                   name="name" placeholder="Ví dụ: Lập trình website">
            @error('name')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="credit_num">Số tín chỉ</label>
            <input type="number" class="form-control" id="credit_num"
                   value="{{ old('credit_num', $subject->credit_num ?? '') }}" name="credit_num" placeholder="Ví dụ: 3">
            @error('credit_num')
            <label id="credit_num-error" class="error mt-2 text-danger" for="credit_num">{{ $message }}</label>
            @enderror
        </div>

        <div class="form-group">
            <label for="total_class_session">Tổng số buổi học</label>
            <input type="number" class="form-control" id="total_class_session"
                   value="{{ old('total_class_session', $subject->total_class_session ?? '') }}" name="total_class_session"
                   placeholder="Ví dụ: 30">
            @error('total_class_session')
            <label id="total_class_session-error" class="error mt-2 text-danger" for="total_class_session">{{ $message }}</label>
            @enderror
        </div>
    </div>
</div>


