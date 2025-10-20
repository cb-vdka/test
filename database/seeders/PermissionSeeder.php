<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard permissions
            ['name' => 'dashboard.view', 'display_name' => 'Xem trang chủ', 'description' => 'Quyền xem trang dashboard chính'],
            
            // User management permissions
            ['name' => 'user.view', 'display_name' => 'Xem danh sách người dùng', 'description' => 'Quyền xem danh sách tất cả người dùng'],
            ['name' => 'user.create', 'display_name' => 'Tạo người dùng', 'description' => 'Quyền tạo tài khoản người dùng mới'],
            ['name' => 'user.edit', 'display_name' => 'Chỉnh sửa người dùng', 'description' => 'Quyền chỉnh sửa thông tin người dùng'],
            ['name' => 'user.delete', 'display_name' => 'Xóa người dùng', 'description' => 'Quyền xóa tài khoản người dùng'],
            ['name' => 'user.restore', 'display_name' => 'Khôi phục người dùng', 'description' => 'Quyền khôi phục tài khoản đã xóa'],
            
            // Account management permissions
            ['name' => 'account.view', 'display_name' => 'Xem tài khoản', 'description' => 'Quyền xem danh sách tài khoản'],
            ['name' => 'account.create', 'display_name' => 'Tạo tài khoản', 'description' => 'Quyền tạo tài khoản mới'],
            ['name' => 'account.edit', 'display_name' => 'Chỉnh sửa tài khoản', 'description' => 'Quyền chỉnh sửa tài khoản'],
            ['name' => 'account.delete', 'display_name' => 'Xóa tài khoản', 'description' => 'Quyền xóa tài khoản'],
            
            // Student management permissions
            ['name' => 'student.view', 'display_name' => 'Xem học viên', 'description' => 'Quyền xem danh sách học viên'],
            ['name' => 'student.create', 'display_name' => 'Tạo học viên', 'description' => 'Quyền tạo hồ sơ học viên mới'],
            ['name' => 'student.edit', 'display_name' => 'Chỉnh sửa học viên', 'description' => 'Quyền chỉnh sửa thông tin học viên'],
            ['name' => 'student.delete', 'display_name' => 'Xóa học viên', 'description' => 'Quyền xóa hồ sơ học viên'],
            ['name' => 'student.export', 'display_name' => 'Xuất danh sách học viên', 'description' => 'Quyền xuất file danh sách học viên'],
            
            // Teacher management permissions
            ['name' => 'teacher.view', 'display_name' => 'Xem giáo viên', 'description' => 'Quyền xem danh sách giáo viên'],
            ['name' => 'teacher.create', 'display_name' => 'Tạo giáo viên', 'description' => 'Quyền tạo hồ sơ giáo viên mới'],
            ['name' => 'teacher.edit', 'display_name' => 'Chỉnh sửa giáo viên', 'description' => 'Quyền chỉnh sửa thông tin giáo viên'],
            ['name' => 'teacher.delete', 'display_name' => 'Xóa giáo viên', 'description' => 'Quyền xóa hồ sơ giáo viên'],
            ['name' => 'teacher.export', 'display_name' => 'Xuất danh sách giáo viên', 'description' => 'Quyền xuất file danh sách giáo viên'],
            
            // Course management permissions
            ['name' => 'course.view', 'display_name' => 'Xem khóa học', 'description' => 'Quyền xem danh sách khóa học'],
            ['name' => 'course.create', 'display_name' => 'Tạo khóa học', 'description' => 'Quyền tạo khóa học mới'],
            ['name' => 'course.edit', 'display_name' => 'Chỉnh sửa khóa học', 'description' => 'Quyền chỉnh sửa thông tin khóa học'],
            ['name' => 'course.delete', 'display_name' => 'Xóa khóa học', 'description' => 'Quyền xóa khóa học'],
            
            // Subject management permissions
            ['name' => 'subject.view', 'display_name' => 'Xem môn học', 'description' => 'Quyền xem danh sách môn học'],
            ['name' => 'subject.create', 'display_name' => 'Tạo môn học', 'description' => 'Quyền tạo môn học mới'],
            ['name' => 'subject.edit', 'display_name' => 'Chỉnh sửa môn học', 'description' => 'Quyền chỉnh sửa thông tin môn học'],
            ['name' => 'subject.delete', 'display_name' => 'Xóa môn học', 'description' => 'Quyền xóa môn học'],
            
            // Class management permissions
            ['name' => 'class.view', 'display_name' => 'Xem lớp học', 'description' => 'Quyền xem danh sách lớp học'],
            ['name' => 'class.create', 'display_name' => 'Tạo lớp học', 'description' => 'Quyền tạo lớp học mới'],
            ['name' => 'class.edit', 'display_name' => 'Chỉnh sửa lớp học', 'description' => 'Quyền chỉnh sửa thông tin lớp học'],
            ['name' => 'class.delete', 'display_name' => 'Xóa lớp học', 'description' => 'Quyền xóa lớp học'],
            
            // Classroom management permissions
            ['name' => 'classroom.view', 'display_name' => 'Xem phòng học', 'description' => 'Quyền xem danh sách phòng học'],
            ['name' => 'classroom.create', 'display_name' => 'Tạo phòng học', 'description' => 'Quyền tạo phòng học mới'],
            ['name' => 'classroom.edit', 'display_name' => 'Chỉnh sửa phòng học', 'description' => 'Quyền chỉnh sửa thông tin phòng học'],
            ['name' => 'classroom.delete', 'display_name' => 'Xóa phòng học', 'description' => 'Quyền xóa phòng học'],
            
            // Schedule management permissions
            ['name' => 'schedule.view', 'display_name' => 'Xem lịch huấn luyện', 'description' => 'Quyền xem lịch huấn luyện'],
            ['name' => 'schedule.create', 'display_name' => 'Tạo lịch huấn luyện', 'description' => 'Quyền tạo lịch huấn luyện mới'],
            ['name' => 'schedule.edit', 'display_name' => 'Chỉnh sửa lịch huấn luyện', 'description' => 'Quyền chỉnh sửa lịch huấn luyện'],
            ['name' => 'schedule.delete', 'display_name' => 'Xóa lịch huấn luyện', 'description' => 'Quyền xóa lịch huấn luyện'],
            
            // Enrollment management permissions
            ['name' => 'enrollment.view', 'display_name' => 'Xem đăng ký', 'description' => 'Quyền xem danh sách đăng ký'],
            ['name' => 'enrollment.create', 'display_name' => 'Tạo đăng ký', 'description' => 'Quyền tạo đăng ký mới'],
            ['name' => 'enrollment.edit', 'display_name' => 'Chỉnh sửa đăng ký', 'description' => 'Quyền chỉnh sửa đăng ký'],
            ['name' => 'enrollment.delete', 'display_name' => 'Xóa đăng ký', 'description' => 'Quyền xóa đăng ký'],
            ['name' => 'enrollment.export', 'display_name' => 'Xuất danh sách đăng ký', 'description' => 'Quyền xuất file danh sách đăng ký'],
            
            // Evaluation management permissions
            ['name' => 'evaluation.view', 'display_name' => 'Xem đánh giá', 'description' => 'Quyền xem danh sách đánh giá'],
            ['name' => 'evaluation.create', 'display_name' => 'Tạo đánh giá', 'description' => 'Quyền tạo đánh giá mới'],
            ['name' => 'evaluation.edit', 'display_name' => 'Chỉnh sửa đánh giá', 'description' => 'Quyền chỉnh sửa đánh giá'],
            ['name' => 'evaluation.delete', 'display_name' => 'Xóa đánh giá', 'description' => 'Quyền xóa đánh giá'],
            
            
            // Major management permissions
            ['name' => 'major.view', 'display_name' => 'Xem chuyên ngành', 'description' => 'Quyền xem danh sách chuyên ngành'],
            ['name' => 'major.create', 'display_name' => 'Tạo chuyên ngành', 'description' => 'Quyền tạo chuyên ngành mới'],
            ['name' => 'major.edit', 'display_name' => 'Chỉnh sửa chuyên ngành', 'description' => 'Quyền chỉnh sửa thông tin chuyên ngành'],
            ['name' => 'major.delete', 'display_name' => 'Xóa chuyên ngành', 'description' => 'Quyền xóa chuyên ngành'],
            
            // Chat management permissions
            ['name' => 'chat.view', 'display_name' => 'Xem chat', 'description' => 'Quyền xem tin nhắn chat'],
            ['name' => 'chat.send', 'display_name' => 'Gửi tin nhắn', 'description' => 'Quyền gửi tin nhắn chat'],
            ['name' => 'chat.delete', 'display_name' => 'Xóa tin nhắn', 'description' => 'Quyền xóa tin nhắn chat'],
            
            // Permission management permissions (chỉ admin)
            ['name' => 'permission.view', 'display_name' => 'Xem quyền hạn', 'description' => 'Quyền xem danh sách quyền hạn'],
            ['name' => 'permission.create', 'display_name' => 'Tạo quyền hạn', 'description' => 'Quyền tạo quyền hạn mới'],
            ['name' => 'permission.edit', 'display_name' => 'Chỉnh sửa quyền hạn', 'description' => 'Quyền chỉnh sửa quyền hạn'],
            ['name' => 'permission.delete', 'display_name' => 'Xóa quyền hạn', 'description' => 'Quyền xóa quyền hạn'],
            ['name' => 'permission.assign', 'display_name' => 'Phân quyền', 'description' => 'Quyền phân quyền cho vai trò và người dùng'],
            
            // Role management permissions (chỉ admin)
            ['name' => 'role.view', 'display_name' => 'Xem vai trò', 'description' => 'Quyền xem danh sách vai trò'],
            ['name' => 'role.create', 'display_name' => 'Tạo vai trò', 'description' => 'Quyền tạo vai trò mới'],
            ['name' => 'role.edit', 'display_name' => 'Chỉnh sửa vai trò', 'description' => 'Quyền chỉnh sửa vai trò'],
            ['name' => 'role.delete', 'display_name' => 'Xóa vai trò', 'description' => 'Quyền xóa vai trò'],
            
            // System management permissions (chỉ admin)
            ['name' => 'system.settings', 'display_name' => 'Cài đặt hệ thống', 'description' => 'Quyền cài đặt cấu hình hệ thống'],
            ['name' => 'system.backup', 'display_name' => 'Sao lưu dữ liệu', 'description' => 'Quyền sao lưu dữ liệu hệ thống'],
            ['name' => 'system.logs', 'display_name' => 'Xem logs', 'description' => 'Quyền xem logs hệ thống'],
            
            // Report permissions
            ['name' => 'report.view', 'display_name' => 'Xem báo cáo', 'description' => 'Quyền xem các báo cáo thống kê'],
            ['name' => 'report.export', 'display_name' => 'Xuất báo cáo', 'description' => 'Quyền xuất file báo cáo'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}