<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trường Quân Sự Quân Khu 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .otp-container h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .otp-code {
            color: #2c7be5;
            font-size: 32px;
            font-weight: bold;
            margin: 20px 0;
        }
        .otp-note {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h1>Mã OTP Của Bạn</h1>
        <div class="otp-code">{{ $otp }}</div>
        <p class="otp-note">Vui lòng sử dụng mã này để hoàn tất quá trình xác minh. Mã chỉ có hiệu lực trong 5 phút.</p>
    </div>
</body>
</html>