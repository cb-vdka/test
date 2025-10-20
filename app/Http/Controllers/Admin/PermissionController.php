<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Roles;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
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
     * Hiển thị danh sách permissions
     */
    public function index(Request $request)
    {
        $this->checkAdminPermission();
        
        $query = Permission::withTrashed();
        
        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($status === 'deleted') {
                $query->whereNotNull('deleted_at');
            }
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $permissions = $query->paginate(10)->withQueryString();
        
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Hiển thị form tạo permission mới
     */
    public function create()
    {
        $this->checkAdminPermission();

        return view('admin.permissions.create');
    }

    /**
     * Lưu permission mới
     */
    public function store(Request $request)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Quyền hạn đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa permission
     */
    public function edit(Permission $permission)
    {
        $this->checkAdminPermission();

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Cập nhật permission
     */
    public function update(Request $request, Permission $permission)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Quyền hạn đã được cập nhật thành công!');
    }

    /**
     * Xóa permission (soft delete)
     */
    public function destroy(Permission $permission)
    {
        $this->checkAdminPermission();

        $permission->delete();
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Quyền hạn đã được xóa thành công!');
    }

    /**
     * Khôi phục permission đã xóa
     */
    public function restore($id)
    {
        $this->checkAdminPermission();

        $permission = Permission::withTrashed()->find($id);
        if ($permission) {
            $permission->restore();
            return redirect()->route('admin.permissions.index')
                ->with('success', 'Quyền hạn đã được khôi phục thành công!');
        }
        return redirect()->route('admin.permissions.index')
            ->with('error', 'Không tìm thấy quyền hạn!');
    }

    /**
     * Hiển thị trang quản lý permissions của role
     */
    public function rolePermissions(Roles $role)
    {
        $this->checkAdminPermission();

        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('permissions.id')->toArray();
        
        return view('admin.permissions.role-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Cập nhật permissions cho role
     */
    public function updateRolePermissions(Request $request, Roles $role)
    {
        $this->checkAdminPermission();

        $permissionIds = $request->input('permissions', []);
        $role->permissions()->sync($permissionIds);

        return redirect()->route('admin.permissions.role-permissions', $role)
            ->with('success', 'Quyền hạn của vai trò đã được cập nhật thành công!');
    }

    /**
     * Hiển thị trang quản lý permissions của user
     */
    public function userPermissions(Account $account)
    {
        $this->checkAdminPermission();

        $permissions = Permission::all();
        $userPermissions = $account->permissions()->pluck('permissions.id')->toArray();
        
        return view('admin.permissions.user-permissions', compact('account', 'permissions', 'userPermissions'));
    }

    /**
     * Cập nhật permissions cho user
     */
    public function updateUserPermissions(Request $request, Account $account)
    {
        $this->checkAdminPermission();

        $permissionIds = $request->input('permissions', []);
        $account->permissions()->sync($permissionIds);

        return redirect()->route('admin.permissions.user-permissions', $account)
            ->with('success', 'Quyền hạn của người dùng đã được cập nhật thành công!');
    }
}
