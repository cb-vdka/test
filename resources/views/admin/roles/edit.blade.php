@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Vai trò')

@section('content')
<div class="page-inner">
            <div class="page-header">
        <h4 class="page-title">Chỉnh sửa Vai trò</h4>
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
                        <a href="{{ route('admin.roles.index') }}">Vai trò</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <span>Chỉnh sửa</span>
            </li>
        </ul>
    </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin Vai trò</h4>
                </div>
                        <div class="card-body">
                            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên vai trò <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $role->name) }}" 
                                                   placeholder="Ví dụ: Editor" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                            </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                                   id="description" name="description" value="{{ old('description', $role->description) }}" 
                                                   placeholder="Mô tả ngắn về vai trò">
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                            </div>
                        </div>
                                
                                <div class="form-group">
                                    <label>Quyền hạn</label>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="permissions[]" value="{{ $permission->id }}" 
                                                           id="permission_{{ $permission->id }}"
                                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                    <label style="line-height: 1.6; margin-left: 30px;" class="form-check-label" for="permission_{{ $permission->id }}">
                                                        <strong>{{ $permission->display_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <code>{{ $permission->name }}</code>
                                                        </small>
                                                    </label>
                                        </div>
                                    </div>
                                        @endforeach
                            </div>
                                    @error('permissions')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                        </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Cập nhật vai trò
                                    </button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
        </div>@endsection
