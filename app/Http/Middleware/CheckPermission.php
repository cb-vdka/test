<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // Kiểm tra nếu user đã đăng nhập thông qua session
        if (empty(session('user_id'))) {
            return redirect()->route('login.index', ['role_id' => 1])->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        }

        // Lấy thông tin role từ session
        $userRole = session('user_role');
        
        if (!$userRole) {
            return redirect()->back()->with('error', 'Không xác định được vai trò của bạn.');
        }

        // Nếu không có permission được yêu cầu, cho phép truy cập
        if (!$permission) {
            return $next($request);
        }

        // Kiểm tra quyền
        if (!$this->hasPermission($userRole, $permission)) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }

    /**
     * Kiểm tra user có quyền hay không
     */
    private function hasPermission($roleId, $permission)
    {
        // Lấy role từ database
        $role = \App\Models\Roles::with('permissions')->find($roleId);
        
        if (!$role) {
            return false;
        }

        // Kiểm tra permission trực tiếp
        $hasPermission = $role->permissions()->where('name', $permission)->exists();
        
        if ($hasPermission) {
            return true;
        }

        // Kiểm tra permission thông qua user_permissions nếu có
        $userId = session('user_id');
        if ($userId) {
            $user = \App\Models\Account::find($userId);
            if ($user && method_exists($user, 'permissions')) {
                $hasUserPermission = $user->permissions()->where('name', $permission)->exists();
                return $hasUserPermission;
            }
        }

        return false;
    }
}

