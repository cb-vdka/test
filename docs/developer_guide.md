
# Hướng dẫn cho Developer

## 1. Yêu cầu hệ thống
- Ngôn ngữ: PHP >= 7.4 / Node.js >= 14 / Python >= 3.8  
- Database: MySQL 5.7+ hoặc PostgreSQL 12+  
- Công cụ: Git, Composer/Yarn/pip, Docker (tùy chọn)

## 2. Cài đặt ban đầu
1. Clone repository:
	```bash
	git clone https://git.example.com/your-repo.git
	cd your-repo
	```

2. Cài đặt thư viện:

```bash
# PHP/Laravel
composer install

# Node.js
yarn install

# Python
pip install -r requirements.txt
```

3. Tạo file `.env` từ mẫu:

```bash
cp .env.example .env
```

4. Cấu hình biến môi trường trong `.env` (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD…)

## 3. Database: Migration & Seeder

1. Tạo migration:

```bash
php artisan make:migration create_permissions_table
```

2. Chạy tất cả migration:

```bash
php artisan migrate
```

3. Tạo seeder cho permissions mặc định:

```bash
php artisan make:seeder PermissionSeeder
```

4. Chạy seeder:

```bash
php artisan db:seed --class=PermissionSeeder
```

## 4. Coding Conventions

Quy tắc đặt tên:

- Class: PascalCase

- Method/variable: camelCase

Thư mục:

- `app/Models` cho Eloquent models

- `app/Http/Controllers` cho controllers

Pull request:

- Branch đặt theo tính năng: `feature/<tên-tính-năng>`

- Mô tả ngắn gọn mục đích PR

## 5. Testing & CI/CD

Chạy unit tests:

```bash
php artisan test
```

Chạy coverage:

```bash
./vendor/bin/phpunit --coverage-html coverage
```

CI pipeline (GitLab/GitHub Actions):

- Stage: install → lint → test → build → deploy

## 6. Debug & Logging

- Log file: `storage/logs/laravel.log`

- Debug mode: bật `APP_DEBUG=true` trong `.env`

## 7. Đóng gói & Triển khai

Build frontend (nếu có):

```bash
npm run build
```

Tạo Docker image:

```bash
docker build -t your-app:latest .
```

---

### Hướng dẫn thực hiện

1. Copy toàn bộ nội dung trên vào file `docs/developer_guide.md`.  
2. Điều chỉnh phần “Yêu cầu hệ thống” và câu lệnh tương ứng với stack thực tế của dự án.  
3. Commit với message: `docs: add developer guide`
