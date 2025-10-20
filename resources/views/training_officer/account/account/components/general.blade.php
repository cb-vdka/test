<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-header">
        <h5 style="margin: 0">Thông tin cán bộ đào tạo</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="account_email">Email</label>
            <input type="text" class="form-control" id="account_email" name="account_email"
                value="{{ isset($getEdit) ? $getEdit->email : old('account_email') }}" placeholder="Email">
        </div>
    </div>
</div>
</div>
