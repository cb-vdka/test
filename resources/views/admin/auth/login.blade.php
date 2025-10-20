<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trường Quân Sự Quân Khu 2</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    
    <link rel="icon" href="{{ asset('default/logo/logo.png') }}" type="image/x-icon" />
</head>

<style>
    :root {
        --military-green: #4B5320; /* Army Green */
        --military-khaki: #F0E68C; /* Khaki for text/accents */
        --military-dark: #212529;   /* Dark Charcoal */
    }

    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Inter', 'Be Vietnam Pro', sans-serif;
        overflow: hidden; /* Prevent scrollbars from background */
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        /* Military themed background (new, higher quality) */
        background-image: linear-gradient(rgba(0,0,0,.55), rgba(0,0,0,.55)), url('https://gitiho.com/uploads/315313/images/hinh-nen-powerpoint%20-quan-doi-viet-nam-10.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .login-container {
        /* stronger contrast for readability */
        background: rgba(8, 12, 9, 0.78);
        backdrop-filter: blur(7px) saturate(110%);
        -webkit-backdrop-filter: blur(7px) saturate(110%);
        padding: 42px 36px 34px;
        border: 1px solid rgba(255, 215, 0, 0.32); /* golden border */
        border-radius: 16px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6), inset 0 0 80px rgba(0,0,0,.25);
        width: 430px;             /* fixed form width on desktop */
        max-width: 92vw;          /* keep usable on very small screens */
        text-align: center;
        color: #fff;
        position: fixed; /* keep centered even when zoom/scroll */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 5;
        overflow: hidden;
    }

    /* decorative top accent (red→yellow ribbon) inspired by flag colors */
    .login-container::before{
        content: "";
        position: absolute; inset: 0 0 auto 0; height: 6px;
        background: linear-gradient(90deg, #c62828, #ffc107, #c62828);
        opacity: .95;
    }
    
    .login-logo {
        width: 96px; height: 96px; object-fit: contain;
        margin-bottom: 18px;
        padding: 10px; border-radius: 50%;
        background: radial-gradient(closest-side, rgba(255,255,255,.12), rgba(255,255,255,.02));
        border: 1px solid rgba(255, 215, 0, .35);
        box-shadow: 0 6px 18px rgba(0,0,0,.35);
    }

    /* Laurel wreath under logo */
    .laurel-wrap{ display:flex; justify-content:center; margin:-6px 0 12px; }
    .laurel{ width:120px; height:auto; opacity:.95; filter: drop-shadow(0 2px 2px rgba(0,0,0,.25)); }

    /* School title lines under logo */
    .school-title{ margin:6px 0 10px; line-height:1.2; }
    .school-title .vn{ color:#ffd54f; font-weight:800; letter-spacing:.6px; }
    .school-title .en{ color:rgba(255,255,255,.85); font-size:.92rem; }

    .login-container h2 {
        font-family: 'Be Vietnam Pro', sans-serif;
        font-weight: 700;
        color: var(--military-khaki);
        font-size: 2.1rem;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    .login-subtitle{
        color: rgba(255,255,255,0.75);
        margin-bottom: 26px;
        font-size: 0.95rem;
    }

    .login-form input[type="email"],
    .login-form input[type="password"] {
        width: 100%;
        height: 48px;
        padding: 12px 14px 12px 52px; /* icon space */
        margin-bottom: 1rem;
        border: 1px solid rgba(255, 215, 0, 0.35);
        border-radius: 10px;
        background-color: rgba(20, 24, 20, 0.65);
        color: #fff;
        font-size: 1em;
        box-sizing: border-box; /* Important for padding and width */
        transition: box-shadow .2s ease, border-color .2s ease, background .2s ease;
    }

    .input-wrap{ position: relative; display: block; }
    .input-icon{
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        color: rgba(255,255,255,0.88);
        font-size: 20px; /* bigger icon */
        pointer-events: none;
    }

    /* Keep icon aligned with input text baseline on all browsers */
    .input-wrap input{ line-height: 1.2; display: block; }
    .input-wrap:focus-within .input-icon{ color: #ffd54f; filter: drop-shadow(0 1px 1px rgba(0,0,0,.25)); }
    .input-wrap:focus-within input{ border-color: #ffd54f; box-shadow: 0 0 0 3px rgba(255,213,79,.18); background-color: rgba(20,24,20,.85); }

    .login-form input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .login-form input:focus {
        outline: none;
        border-color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        border: 0;
        border-radius: 10px;
        background-image: linear-gradient(135deg, #ffca28, #ffc107); /* vivid amber for strong contrast */
        color: #1b1b1b;
        font-family: 'Be Vietnam Pro', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: transform .15s ease, box-shadow .2s ease, background .3s ease, filter .2s ease;
        box-shadow: 0 10px 24px rgba(255, 193, 7, .25), inset 0 -2px 0 rgba(0,0,0,.15);
    }

    .submit-btn:hover {
        background-image: linear-gradient(135deg, #ffb300, #ffa000);
        color: #111;
        box-shadow: 0 12px 28px rgba(255, 193, 7, .35);
    }

    .submit-btn:active { transform: translateY(1px); filter: brightness(.98); }

    /* removed remember/forgot row */
    
    /* Error Message Styling */
    .message_error {
        color: #ff6b6b; /* A brighter red for visibility */
        font-size: 0.85em;
        text-align: left;
        margin-top: -15px;
        margin-bottom: 15px;
    }
    
    /* Removed the divider as it's not needed with only one login method */
    .divider {
       display: none;
    }
    /* Fix autofill background (Chrome, Edge, Safari) */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #fff !important; /* chữ trắng */
        -webkit-box-shadow: 0 0 0px 1000px rgba(20, 24, 20, 0.85) inset !important; /* nền đen dịu */
        box-shadow: 0 0 0px 1000px rgba(20, 24, 20, 0.85) inset !important;
        border: 1px solid rgba(255, 215, 0, 0.35) !important;
        transition: background-color 5000s ease-in-out 0s; /* fix hiệu ứng mờ */
    }


</style>

<body>
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
</body>

</html>