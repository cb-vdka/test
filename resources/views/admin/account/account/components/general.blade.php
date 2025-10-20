<div class="form-group">
    <label for="account_name">Tên thành viên</label>
    <input type="text" class="form-control" id="account_name" name="account_name"
        value="{{ isset($getEdit) ? $getEdit->name : old('account_name') }}" placeholder="Tên thành viên">
    @error('account_name')
        <p class="message_error">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="account_email">Email</label>
    <input type="email" class="form-control" id="account_email" name="account_email" placeholder="Email"
        value="{{ isset($getEdit) ? $getEdit->email : old('account_email') }}">
    @error('account_email')
        <p class="message_error">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="password">Mật khẩu</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu"
        value="{{ old('password') }}" {{ isset($getEdit) ? '' : 'required' }}>
    @error('password')
        <p class="message_error">{{ $message }}</p>
    @enderror
    @if(isset($getEdit))
        <small class="form-text text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
    @endif
</div>
<div class="form-group">
    <label for="password_confirmation">Xác nhận mật khẩu</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu"
        value="{{ old('password_confirmation') }}" {{ isset($getEdit) ? '' : 'required' }}>
    @error('password_confirmation')
        <p class="message_error">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="role_id">Vai trò</label>
    <select class="form-control" id="role_id" name="role_id" required>
        <option value="">-- Chọn vai trò --</option>
        @if(isset($roles))
            @foreach($roles as $role)
                <option value="{{ $role->id }}" 
                        {{ (isset($getEdit) && $getEdit->role_id == $role->id) || old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->display_name ?? $role->name }}
                </option>
            @endforeach
        @endif
    </select>
    @error('role_id')
        <p class="message_error">{{ $message }}</p>
    @enderror
</div>
