
# Xử lý Sự cố (Troubleshooting)

## 1. Lỗi Migration

**Hiện tượng**  
- Chạy `php artisan migrate` (hoặc tương tự) bị dừng với thông báo lỗi.

**Nguyên nhân phổ biến**  
- File migration trùng tên hoặc đã tồn tại trên database.  
- Thiếu cột/khóa ngoại tham chiếu không hợp lệ.  
- Sai quyền truy cập database.

**Cách khắc phục**  
1. Kiểm tra thư mục `database/migrations` không có file trùng tên.  
2. Xóa bảng liên quan rồi chạy lại:  
```bash
php artisan migrate:rollback --step=1
php artisan migrate
```
Cập nhật đúng cột hoặc FK trong migration rồi thử lại.

Kiểm tra cấu hình DB trong .env.

## 2. Lỗi “Permission Denied”

**Hiện tượng**

- Khi truy cập route có middleware/Gate, API trả về 403 Forbidden.

**Nguyên nhân phổ biến**

- User chưa được gán role hoặc permission tương ứng.

- Slug permission trên route không khớp với slug trong DB.

- Cache permissions chưa được clear.

**Cách khắc phục**

1. Kiểm tra bảng `role_permissions` và `user_permissions`.

2. Đảm bảo route khai báo đúng:

```php
->middleware('permission:view_users');
```

3. Chạy lại cache config/permission:

```bash
php artisan config:cache
php artisan cache:clear
```

## 3. UI Không Hiển Thị / Lỗi Frontend

**Hiện tượng**

- Trang web tải không đầy đủ CSS/JS.

- Button hoặc form không hoạt động.

**Nguyên nhân phổ biến**

- Quên build frontend: file assets chưa được compile.

- Thiếu kết nối đến API (CORS, base URL sai).

- Lỗi JavaScript console.

**Cách khắc phục**

1. Chạy build assets:

```bash
npm install
npm run build
```

2. Kiểm tra console trên trình duyệt, sửa lỗi JS.

3. Kiểm tra cấu hình CORS trong backend.

## 4. Lỗi Authentication / Token

**Hiện tượng**

- API trả về 401 Unauthorized ngay cả khi đã kèm token.

**Nguyên nhân phổ biến**

- Token hết hạn hoặc sai định dạng.

- Middleware xác thực chưa đăng ký đúng.

**Cách khắc phục**

1. Sinh lại token qua endpoint login.

2. Kiểm tra header gửi đúng:

```
Authorization: Bearer <token>
```

3. Kiểm tra file middleware: `app/Http/Middleware/Authenticate.php`

## 5. Kiểm tra Log & Báo lỗi

- Log backend: `storage/logs/laravel.log` (Laravel)

- Debug mode: bật `APP_DEBUG=true`

- Khi gặp lỗi không rõ, gửi file log và steps tái tạo cho team.
