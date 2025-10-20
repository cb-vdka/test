<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles;

class Account extends Model
{
    use HasFactory;
    public $table = 'accounts';
    protected $data;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'OTP',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
    public function getAllAccount($keyword = null, $sort = 10)
    {
        $data = Account::orderBy('created_at', 'DESC')
            ->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->paginate($sort);
        return $data;
    }
    public function getEditAccount($id)
    {
        $data = Account::find($id);

        return $data;
    }
    public function updateAccount($data, $id)
    {
        $account = Account::find($id);

        return $account->update($data);
    }
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    /**
     * Lấy tất cả permissions của user thông qua role
     */
    public function permissions()
    {
        if (!$this->role) {
            return collect();
        }
        return $this->role->permissions();
    }

    /**
     * Kiểm tra user có permission hay không
     */
    public function hasPermission($permission)
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->permissions()->where('name', $permission)->exists();
    }

    /**
     * Kiểm tra user có role hay không
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

}
