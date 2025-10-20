<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trường Quân Sự Quân Khu 2</title>
    <link rel="stylesheet" href="{{ asset('admin') }}/css/customize.css">
    <link rel="icon" href="{{ asset('admin') }}/img/banner_home/logo_web.jpg" type="image/x-icon" />

</head>

<body>
    <div class="login-container">
        <h2 style="margin-bottom: 0;">Xác Nhận Mã OTP</h2>

        <div class="dividerotp" style="margin-bottom: 20px; margin-top: 20px;">Nhập mã OTP bên dưới</div>

        <form action="{{ route('login.confirm_otp') }}" method="POST">
            @csrf
            <input class="form" type="text" name="otp" placeholder="Mã OTP Của Bạn" style="margin-bottom: 15px;">
            @error('otp')
                <div class="message_error">{{ $message }}</div>
            @enderror
            <button type="submit" class="submit-btn">Xác Nhận</button>
        </form>
    </div>
</body>

</html>
