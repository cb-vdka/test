<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền admin trong mỗi method
    }

    /**
     * Kiểm tra quyền admin
     */
    private function checkAdminPermission()
    {
        if (session('user_role') != 1) {
            abort(403, 'Bạn không có quyền truy cập trang này');
        }
    }

    /**
     * Hiển thị danh sách roles
     */
    public function index()
    {
        $this->checkAdminPermission();

        $roles = Roles::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Hiển thị form tạo role mới
     */
    public function create()
    {
        $this->checkAdminPermission();

        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Lưu role mới
     */
    public function store(Request $request)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        $role = Roles::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Gán permissions cho role
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Vai trò đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa role
     */
    public function edit(Roles $role)
    {
        $this->checkAdminPermission();

        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('permissions.id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Cập nhật role
     */
    public function update(Request $request, Roles $role)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Cập nhật permissions cho role
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Vai trò đã được cập nhật thành công!');
    }

    /**
     * Xóa role (soft delete)
     */
    public function destroy(Roles $role)
    {
        $this->checkAdminPermission();

        // Kiểm tra xem role có đang được sử dụng không
        if ($role->accounts()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Không thể xóa vai trò này vì đang có người dùng sử dụng!');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Vai trò đã được xóa thành công!');
    }

    /**
     * Khôi phục role đã xóa
     */
    public function restore($id)
    {
        $this->checkAdminPermission();

        $role = Roles::withTrashed()->find($id);
        if ($role) {
            $role->restore();
            return redirect()->route('admin.roles.index')
                ->with('success', 'Vai trò đã được khôi phục thành công!');
        }
        return redirect()->route('admin.roles.index')
            ->with('error', 'Không tìm thấy vai trò!');
    }
}
