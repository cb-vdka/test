@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Quyền hạn')

@section('content')
<div class="page-inner">
            <div class="page-header">
        <h4 class="page-title">Chỉnh sửa Quyền hạn</h4>
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
                <a href="{{ route('admin.permissions.index') }}">Quyền hạn</a>
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
                            <h4 class="card-title">Thông tin Quyền hạn</h4>
                </div>
                        <div class="card-body">
                            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên quyền <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $permission->name) }}" 
                                                   placeholder="Ví dụ: user.create" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Tên quyền phải là duy nhất và theo định dạng: module.action
                                            </small>
                                </div>
                            </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="display_name">Tên hiển thị <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                                   id="display_name" name="display_name" value="{{ old('display_name', $permission->display_name) }}" 
                                                   placeholder="Ví dụ: Tạo người dùng" required>
                                            @error('display_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                </div>
                            </div>
                        </div>
                                
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                              placeholder="Mô tả chi tiết về quyền hạn này">{{ old('description', $permission->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                        </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Cập nhật quyền hạn
                                    </button>
                                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
        </div>@endsection
