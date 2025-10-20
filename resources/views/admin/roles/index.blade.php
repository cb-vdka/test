@extends('admin.layouts.app')

@section('title', 'Quản lý Vai trò')

@section('content')
<div class="page-inner">
            <div class="page-header">
        <h4 class="page-title">Quản lý Vai trò</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <span>Vai trò</span>
            </li>
        </ul>
    </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Danh sách Vai trò</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('account.create') }}" class="btn btn-success btn-round mr-2">
                                        <i class="fa fa-user-plus"></i>
                                        Tạo Account
                                    </a>
                                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-round">
                                        <i class="fa fa-plus"></i>
                                        Thêm vai trò
                                    </a>
                                </div>
                            </div>
                </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                        </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                        </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên vai trò</th>
                                            <th>Mô tả</th>
                                            <th>Số quyền hạn</th>
                                            <th>Số người dùng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>
                                                    <strong>{{ $role->name }}</strong>
                                                </td>
                                                <td>{{ $role->description ?? 'Không có mô tả' }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ $role->permissions->count() }} quyền</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $role->accounts->count() }} người</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.permissions.role-permissions', $role) }}" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Phân quyền">
                                                            <i class="fa fa-key"></i>
                                                        </a>
                                                        <a href="{{ route('admin.roles.edit', $role) }}" 
                                                           class="btn btn-info btn-sm" 
                                                           title="Sửa">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @if($role->accounts->count() == 0)
                                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-danger btn-sm" 
                                                                        title="Xóa"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-danger btn-sm" 
                                                                    disabled 
                                                                    title="Không thể xóa vì đang có người dùng sử dụng">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có vai trò nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                    </div>

                            <!-- Custom Pagination -->
                            @include('admin.components.pagination', ['paginator' => $roles])
                </div>
            </div>
        </div>
    </div>
        </div>@endsection
