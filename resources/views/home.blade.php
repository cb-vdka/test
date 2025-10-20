<!-- header -->
@include('partials.header')

<style>
     .home-login-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: linear-gradient(rgba(0, 0, 0, .55), rgba(0, 0, 0, .55)), url("{{ asset('default/banner/banner-login.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        overflow: hidden
    }
</style>
<link rel="stylesheet" href="{{ asset('client/css/login.css') }}">

<section class="home-login-section">
    <div class="login-container">
        <a href="{{ route('home') }}">
            <img src="{{ asset('default/logo/logo.png') }}" alt="Logo" class="login-logo">
        </a>
        <div class="school-title">
            <div class="vn">TRƯỜNG QUÂN SỰ QUÂN KHU 2</div>
            <div class="en">MILITARY SCHOOL OF MILITARY REGION 2</div>
        </div>
        <h2>Đăng Nhập</h2>
        <form action="{{ route('login.authenticate') }}" method="POST" class="login-form" autocomplete="on">
            @csrf
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="username email" autocapitalize="off" spellcheck="false">
            </div>
            @error('email')
            <div class="message_error">{{ $message }}</div>
            @enderror
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" placeholder="Mật khẩu" autocomplete="current-password">
            </div>
            @error('password')
            <div class="message_error">{{ $message }}</div>
            @enderror
            <button type="submit" class="submit-btn">Đăng nhập</button>
        </form>
    </div>
</section>


<!-- footer -->
@include('partials.footer')