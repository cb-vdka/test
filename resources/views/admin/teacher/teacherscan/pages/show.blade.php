<div class="card">
    <div class="card-header">
        <h4>Thông Tin Giảng Viên</h4>
    </div>
    <div class="card-body">
        <div style="display: flex;">
            <div style="flex: 1;">
                <p><strong>Tên:</strong> {{ $userInfo->name }}</p>
                <p><strong>Ngày sinh:</strong> {{ $userInfo->date_of_birth ? $userInfo->date_of_birth->format('d/m/Y') : 'N/A' }}</p>
                <p><strong>Giới tính:</strong> {{ $userInfo->gender }}</p>
                <p><strong>Số CCCD:</strong> {{ $userInfo->id_number }}</p>
                <p><strong>Quốc tịch:</strong> {{ $userInfo->nationality }}</p>
                <p><strong>Hộ khẩu thường trú:</strong> {{ $userInfo->home }}</p>
                <p><strong>Địa chỉ:</strong> {{ $userInfo->address }}</p>
                <p><strong>Tỉnh/Thành phố:</strong> {{ $userInfo->province }}</p>
                <p><strong>Quận/Huyện:</strong> {{ $userInfo->district }}</p>
                <p><strong>Phường/Xã:</strong> {{ $userInfo->ward }}</p>
                <p><strong>Đường:</strong> {{ $userInfo->street }}</p>
                <p><strong>Ngày hết hạn:</strong> {{ $userInfo->doe ? $userInfo->doe->format('d/m/Y') : 'N/A' }}</p>
            </div>
            <div style="flex: 1; text-align: right;">
                <img src="{{ Storage::url($userInfo->cccd_front_image) }}" alt="CCCD Front" style="max-width: 100%; height: auto;">
                <img src="{{ Storage::url($userInfo->cccd_back_image) }}" alt="CCCD Back" style="max-width: 100%; height: auto; margin-top: 20px;">
            </div>
        </div>
        <a href="{{ route('teacher.scan') }}" class="btn btn-primary">Quay lại</a>
    </div>
</div>
