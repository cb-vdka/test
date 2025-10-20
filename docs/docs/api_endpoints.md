# API Endpoints

## 1. Authentication

### Đăng nhập
**POST** `/api/login`

- Headers:
  - Content-Type: application/json

- Request:
```json
{
  "email": "user@example.com",
  "password": "secret"
}
```

- Response (200 OK):
```json
{
  "token": "jwt_token_here",
  "token_type": "Bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "Nguyễn Văn A",
    "email": "user@example.com"
  }
}
```

- Errors:
  - 401 Unauthorized – Sai email hoặc mật khẩu
  - 422 Validation Error – Thiếu trường bắt buộc

### Đăng xuất
**POST** `/api/logout`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
{
  "message": "Logged out successfully"
}
```

- Errors:
  - 401 Unauthorized – Token không hợp lệ

## 2. Permissions

### Lấy danh sách Permission
**GET** `/api/permissions`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
[
  {
    "id": 1,
    "name": "View Users",
    "slug": "view_users",
    "description": "Cho phép xem danh sách người dùng"
  },
  {
    "id": 2,
    "name": "Edit Users",
    "slug": "edit_users",
    "description": "Cho phép chỉnh sửa người dùng"
  }
]
```

### Tạo Permission
**POST** `/api/permissions`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "name": "Delete Users",
  "slug": "delete_users",
  "description": "Cho phép xóa người dùng"
}
```

- Response (201 Created):
```json
{
  "id": 3,
  "name": "Delete Users",
  "slug": "delete_users",
  "description": "Cho phép xóa người dùng"
}
```

### Cập nhật Permission
**PUT** `/api/permissions/{id}`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "name": "Modify Users",
  "slug": "modify_users",
  "description": "Cho phép sửa thông tin người dùng"
}
```

- Response (200 OK):
```json
{
  "id": 3,
  "name": "Modify Users",
  "slug": "modify_users",
  "description": "Cho phép sửa thông tin người dùng"
}
```

### Xóa Permission
**DELETE** `/api/permissions/{id}`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
{
  "message": "Permission deleted successfully"
}
```

## 3. Roles

### Lấy danh sách Role
**GET** `/api/roles`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
[
  {
    "id": 1,
    "name": "Admin",
    "permissions": ["view_users", "edit_users", "delete_users"]
  },
  {
    "id": 2,
    "name": "Teacher",
    "permissions": ["view_users"]
  }
]
```

### Tạo Role
**POST** `/api/roles`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "name": "Student",
  "permissions": []
}
```

- Response (201 Created):
```json
{
  "id": 3,
  "name": "Student",
  "permissions": []
}
```

### Cập nhật Role
**PUT** `/api/roles/{id}`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "name": "Tutor",
  "permissions": [1, 2]
}
```

- Response (200 OK):
```json
{
  "id": 2,
  "name": "Tutor",
  "permissions": ["view_users", "edit_users"]
}
```

### Xóa Role
**DELETE** `/api/roles/{id}`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
{
  "message": "Role deleted successfully"
}
```

### Gán Permission cho Role
**POST** `/api/roles/{id}/permissions`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "permissions": [1, 3]
}
```

- Response (200 OK):
```json
{
  "message": "Permissions assigned successfully"
}
```

## 4. Users

### Lấy danh sách User
**GET** `/api/users`

- Headers:
  - Authorization: Bearer <token>

- Response (200 OK):
```json
[
  {
    "id": 1,
    "name": "Nguyễn Văn A",
    "email": "user@example.com",
    "roles": ["Admin"],
    "permissions": ["view_users", "edit_users"]
  },
  {
    "id": 2,
    "name": "Trần Thị B",
    "email": "teacher@example.com",
    "roles": ["Teacher"],
    "permissions": ["view_users"]
  }
]
```

### Tạo User
**POST** `/api/users`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "name": "Lê Văn C",
  "email": "student@example.com",
  "password": "secret",
  "roles": [3]
}
```

- Response (201 Created):
```json
{
  "id": 3,
  "name": "Lê Văn C",
  "email": "student@example.com",
  "roles": ["Student"],
  "permissions": []
}
```

### Gán Role cho User
**POST** `/api/users/{id}/roles`

- Headers:
  - Authorization: Bearer <token>
  - Content-Type: application/json

- Request:
```json
{
  "roles": [2, 3]
}
```

- Response (200 OK):
```json
{
  "message": "Roles assigned successfully"
}
```

## Error Codes
401 Unauthorized – Token không hợp lệ hoặc chưa đăng nhập
403 Forbidden – Không có quyền truy cập 
404 Not Found – Endpoint hoặc resource không tồn tại 
422 Validation Error – Dữ liệu gửi lên không hợp lệ 
500 Internal Server Error – Lỗi hệ thống 
