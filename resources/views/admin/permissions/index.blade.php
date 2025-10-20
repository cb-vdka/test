@extends('admin.layouts.app')

@section('title', 'Quản lý Quyền hạn')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Quản lý Quyền hạn</h4>
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
                <span>Quyền hạn</span>
            </li>
        </ul>
    </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Danh sách Quyền hạn</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('account.create') }}" class="btn btn-success btn-round mr-2">
                                        <i class="fa fa-user-plus"></i>
                                        Tạo Account
                                    </a>
                                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-round">
                                        <i class="fa fa-plus"></i>
                                        Thêm quyền hạn
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-fixed">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-fixed">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Search and Filter Form -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <form method="GET" action="{{ route('admin.permissions.index') }}" class="search-form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">Tìm kiếm:</label>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           id="search" 
                                                           name="search" 
                                                           value="{{ request('search') }}" 
                                                           placeholder="Nhập tên quyền, tên hiển thị hoặc mô tả...">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="status">Trạng thái:</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">Tất cả</option>
                                                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                                        <option value="deleted" {{ request('status') === 'deleted' ? 'selected' : '' }}>Đã xóa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sort_by">Sắp xếp theo:</label>
                                                    <select class="form-control" id="sort_by" name="sort_by">
                                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Tên quyền</option>
                                                        <option value="display_name" {{ request('sort_by') === 'display_name' ? 'selected' : '' }}>Tên hiển thị</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="sort_order">Thứ tự:</label>
                                                    <select class="form-control" id="sort_order" name="sort_order">
                                                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i> Tìm kiếm
                                                </button>
                                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-refresh"></i> Làm mới
                                                </a>
                                                @if(request()->hasAny(['search', 'status', 'sort_by', 'sort_order']))
                                                    <span class="badge badge-info ml-2">
                                                        <i class="fa fa-filter"></i> Đang lọc
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Search Results Info -->
                            @if(request()->hasAny(['search', 'status', 'sort_by', 'sort_order']))
                                <div class="search-results-info">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-info-circle mr-2"></i>
                                        <span>
                                            @if(request('search'))
                                                Tìm kiếm: "<strong>{{ request('search') }}</strong>"
                                            @endif
                                            @if(request('status'))
                                                | Trạng thái: <strong>{{ request('status') === 'active' ? 'Đang hoạt động' : 'Đã xóa' }}</strong>
                                            @endif
                                            @if(request('sort_by'))
                                                | Sắp xếp: <strong>{{ request('sort_by') === 'created_at' ? 'Ngày tạo' : (request('sort_by') === 'name' ? 'Tên quyền' : 'Tên hiển thị') }}</strong>
                                                <strong>{{ request('sort_order') === 'desc' ? '↓' : '↑' }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên quyền</th>
                                            <th>Tên hiển thị</th>
                                            <th>Mô tả</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>
                                                    <code>{{ $permission->name }}</code>
                                                </td>
                                                <td>{{ $permission->display_name }}</td>
                                                <td>{{ $permission->description ?? 'Không có mô tả' }}</td>
                                                <td>
                                                    @if($permission->deleted_at)
                                                        <span class="badge badge-danger">Đã xóa</span>
                                                    @else
                                                        <span class="badge badge-success">Hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if($permission->deleted_at)
                                                            <form action="{{ route('admin.permissions.restore', $permission->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-warning btn-sm" 
                                                                        title="Khôi phục">
                                                                    <i class="fa fa-undo"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                                               class="btn btn-info btn-sm" 
                                                               title="Sửa">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-danger btn-sm" 
                                                                        title="Xóa"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa quyền hạn này?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    @if(request()->hasAny(['search', 'status']))
                                                        <div class="no-results">
                                                            <i class="fa fa-search"></i>
                                                            <h5>Không tìm thấy kết quả</h5>
                                                            <p>Không có quyền hạn nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                                                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">
                                                                <i class="fa fa-refresh"></i> Xem tất cả
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="no-results">
                                                            <i class="fa fa-shield-alt"></i>
                                                            <h5>Chưa có quyền hạn nào</h5>
                                                            <p>Hệ thống chưa có quyền hạn nào. Hãy tạo quyền hạn đầu tiên.</p>
                                                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                                                                <i class="fa fa-plus"></i> Tạo quyền hạn đầu tiên
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Custom Pagination -->
                            @include('admin.components.pagination', ['paginator' => $permissions])
                        </div>
                    </div>
                </div>
    </div>
</div>
@endsection
