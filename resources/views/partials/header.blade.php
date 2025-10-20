<!DOCTYPE html>
<html lang="en">

<head>
    <title>Trường Quân Sự Quân Khu 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Staatliches&display=swap" rel="stylesheet">
    
    {{-- <link rel="stylesheet" href="{{ asset('admin') }}/css/bootstrap.min.css" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('admin') }}assets/css/templatemo.css" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('admin') }}assets/css/customsize.css" /> --}}
    <link rel="stylesheet" href="{{ asset('client/css/main.css') }}">
    <link rel="icon" href="{{ asset('default/logo/logo.png') }}" type="image/x-icon" />

</head>



<body>


<header class="sticky-top shadow-sm">
    <div class="header-main header-background-pattern">
        <div class="header-left"></div>

        <a href="{{ route('home') }}" class="header-center-block">
            <img src="{{ asset('default/logo/logo.png') }}" alt="Logo" class="header-logo">
            <div class="header-text">
                <div class="header-title-vi">TRƯỜNG QUÂN SỰ QUÂN KHU 2</div>
                <div class="header-title-en">MILITARY SCHOOL OF MILITARY REGION 2</div>
            </div>
        </a>

        <div class="header-right">
            <!-- <div>
                <a href="{{ route('login.index') }}" class="btn btn-link text-decoration-none" aria-label="Đăng nhập">
                    <i class="bi bi-person-circle" style="font-size: 2.2rem; color: #fff;"></i>
                </a>
            </div> -->
        </div>
        
    </div>

<div class="nav-center">
    <nav class="navbar navbar-expand-lg header-bottom-nav">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavCollapse" aria-controls="topNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavCollapse">
                <ul class="navbar-nav mx-auto">
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">TRANG CHỦ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">GIỚI THIỆU</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news') }}">TIN TỨC – THÔNG BÁO</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('education') }}">GIÁO DỤC – ĐÀO TẠO</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('activities') }}">HOẠT ĐỘNG PHONG TRÀO</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('library') }}">THƯ VIỆN SỐ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('policies') }}">VĂN BẢN - CHÍNH SÁCH</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">LIÊN HỆ - HỎI ĐÁP</a></li> -->
                </ul>
            </div>

        </div>
    </nav>
</div>

</header>
  
