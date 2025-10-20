# Database Schema

## Tổng quan
Tài liệu này mô tả cấu trúc các bảng chính trong hệ thống phân quyền và mối quan hệ giữa chúng.

---

## Bảng permissions
- **id** (PK, BIGINT, auto-increment)  
- **name** (VARCHAR(255), NOT NULL)  
- **slug** (VARCHAR(255), UNIQUE, NOT NULL)  
- **description** (TEXT, NULLABLE)  
- **created_at** (TIMESTAMP, NOT NULL)  
- **updated_at** (TIMESTAMP, NOT NULL)

## Bảng roles
- **id** (PK, BIGINT, auto-increment)  
- **name** (VARCHAR(255), NOT NULL)  
- **description** (TEXT, NULLABLE)  
- **created_at** (TIMESTAMP, NOT NULL)  
- **updated_at** (TIMESTAMP, NOT NULL)

## Bảng role_permissions
- **role_id** (FK → roles.id, BIGINT, NOT NULL)  
- **permission_id** (FK → permissions.id, BIGINT, NOT NULL)  
- **created_at** (TIMESTAMP, NOT NULL)

## Bảng user_permissions
- **user_id** (FK → users.id, BIGINT, NOT NULL)  
- **permission_id** (FK → permissions.id, BIGINT, NOT NULL)  
- **created_at** (TIMESTAMP, NOT NULL)

## Bảng users
- **id** (PK, BIGINT, auto-increment)  
- **name** (VARCHAR(255), NOT NULL)  
- **email** (VARCHAR(255), UNIQUE, NOT NULL)  
- **password** (VARCHAR(255), NOT NULL)  
- **created_at** (TIMESTAMP, NOT NULL)  
- **updated_at** (TIMESTAMP, NOT NULL)

---

## Quan hệ giữa các bảng
- **roles** ↔︎ **permissions**: N:N qua **role_permissions**  
- **users** ↔︎ **permissions**: N:N qua **user_permissions**  
- Ngoài ra, người dùng có thể kế thừa permissions thông qua roles.

---

## ERD Diagram
Sơ đồ ERD được lưu trong file `docs/erd.drawio`.  
Có thể mở bằng extension **Draw.io Integration** hoặc import vào dbdiagram.io.

