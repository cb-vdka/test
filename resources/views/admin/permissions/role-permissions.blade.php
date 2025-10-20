@extends('admin.layouts.app')

@section('title', 'Quản lý Quyền hạn của Vai trò')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Quản lý Quyền hạn của Vai trò: {{ $role->name }}</h4>
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
                <span>Quyền hạn</span>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Phân quyền cho vai trò: {{ $role->name }}</h4>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-round ml-auto">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-fixed">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.permissions.update-role-permissions', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input me-10" type="checkbox"
                                        name="permissions[]" value="{{ $permission->id }}"
                                        id="permission_{{ $permission->id }}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    <label style="line-height: 1.6; margin-left: 30px;" class="form-check-label" for="permission_{{ $permission->id }}">
                                        <strong>{{ $permission->display_name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <code>{{ $permission->name }}</code>
                                        </small>
                                        @if($permission->description)
                                        <br>
                                        <small class="text-info">{{ $permission->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Cập nhật quyền hạn
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