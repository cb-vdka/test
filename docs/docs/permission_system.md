
# Hệ thống Phân quyền

## 1. Khái niệm cơ bản
- **Permission**: Quyền cụ thể (ví dụ: view_users, edit_users).  
- **Role**: Tập hợp nhiều Permission (ví dụ: Admin, Teacher, Student).  
- **User**: Người dùng cuối, có thể được gán Role và/hoặc Permission độc lập.

---

## 2. Mô hình dữ liệu
- User ↔︎ Role: Nhiều-nhiều (bảng trung gian `user_roles`).  
- Role ↔︎ Permission: Nhiều-nhiều (bảng trung gian `role_permissions`).  
- User ↔︎ Permission: Nhiều-nhiều (bảng trung gian `user_permissions`), dùng để gán trực tiếp bypass Role.

---

## 3. Luồng phân quyền
1. Khi đăng nhập, hệ thống cấp JWT/Session cho User.  
2. Mỗi request kèm token, middleware đọc token để xác định User.  
3. Dựa vào Role và Permission gán sẵn, middleware/Gate quyết định cho phép hay từ chối truy cập.  
4. Nếu User có quyền (direct hoặc thông qua Role) → tiếp tục, ngược lại → trả về 403 Forbidden.

---

## 4. Middleware & Gates

### Middleware `CheckPermission`
- Vị trí: `app/Http/Middleware/CheckPermission.php`  
- Cách dùng:
```php
Route::get('/users', 'UserController@index')
	->middleware('permission:view_users');
```

Logic:

- Lấy slug permission từ route.
- Kiểm tra trong `$user->allPermissions()`.
- Nếu không có → throw 403.

### Middleware `CheckRole`
- Vị trí: `app/Http/Middleware/CheckRole.php`

- Cách dùng:
```php
Route::delete('/roles/{id}', 'RoleController@delete')
	->middleware('role:Admin');
```

- Logic tương tự, kiểm tra danh sách roles.

### Gates & Policies
- Định nghĩa Gate trong `AuthServiceProvider`:
```php
Gate::define('edit-users', fn($user) => $user->hasPermission('edit_users'));
```
- Policy classes (nếu dùng):

- `app/Policies/UserPolicy.php` với method `view`, `update`, `delete`.
- Đăng ký trong `AuthServiceProvider`.

## 5. Tình huống mẫu

| Role  | Permissions | Mô tả |
|---|---|---|
| Admin | view_users, edit_users, delete_users, manage_roles | Toàn quyền |
| Teacher | view_users | Chỉ xem danh sách |
| Student | — | Không có quyền quản lý người dùng |

Ví dụ:

- User A gán Role = Teacher → chỉ có thể xem, khi gọi route có middleware `permission:edit_users` sẽ bị 403.

## 6. Tài liệu tham khảo
- File middleware: `app/Http/Middleware/CheckPermission.php`
- File gates: `app/Providers/AuthServiceProvider.php`
- Policy classes: `app/Policies/*.php`
