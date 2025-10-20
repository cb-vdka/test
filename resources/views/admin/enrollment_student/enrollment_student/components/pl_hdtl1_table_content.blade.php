<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý {{ $title }}</h5>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPlHdtl1Modal" onclick="setPlHdtl1FileType('{{ $fileType }}', '{{ $title }}')">
                <i class="fas fa-plus me-1"></i>Tải lên {{ $title }}
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center py-3">#</th>
                        <th width="25%" class="py-3">Lớp học</th>
                        <th width="35%" class="py-3">File {{ $title }}</th>
                        <th width="15%" class="text-center py-3">Trạng thái</th>
                        <th width="20%" class="text-center py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody id="plHdtl1TableBody_{{ $fileType }}">
            @php
                $filteredFiles = isset($plHdtl1Files) ? $plHdtl1Files->where('file_type', $fileType) : collect();
            @endphp
            
            @if($filteredFiles->count() > 0)
                @foreach($filteredFiles as $file)
                    <tr class="align-middle">
                        <td class="text-center py-3">
                            <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold text-dark">{{ $file->class->name ?? 'Lớp không xác định' }}</div>
                            <small class="text-muted">Lớp học</small>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">{{ $file->file_name }}</div>
                                    <small class="text-muted">{{ $file->formatted_file_size }}</small>
                                </div>
                                <a href="/wp-admin/enrollment_student/download-pl-hdtl1-file/{{ $file->id }}" class="btn btn-outline-success btn-sm" title="Tải xuống">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                        <td class="text-center py-3">
                            @if($file->status === 'public')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    Công khai
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    Tạm ẩn
                                </span>
                            @endif
                        </td>
                        <td class="text-center py-3">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" title="Cập nhật" data-file-id="{{ $file->id }}" data-file-name="{{ $file->file_name }}" data-file-type="{{ $file->file_type }}" onclick="openUpdatePlHdtl1Modal(this.dataset.fileId, this.dataset.fileName, this.dataset.fileType)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" title="Công khai/Tạm ẩn" data-file-id="{{ $file->id }}" data-file-status="{{ $file->status }}" onclick="togglePlHdtl1Status(this.dataset.fileId, this.dataset.fileStatus)">
                                    @if($file->status === 'public')
                                        <i class="fas fa-eye-slash"></i>
                                    @else
                                        <i class="fas fa-eye"></i>
                                    @endif
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Xóa" data-file-id="{{ $file->id }}" onclick="confirmDeletePlHdtl1(this.dataset.fileId)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <h5 class="text-muted">Chưa có file {{ $title }} nào</h5>
                            <p class="text-muted mb-3">Hãy tải lên file {{ $title }} đầu tiên để bắt đầu</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPlHdtl1Modal" onclick="setPlHdtl1FileType('{{ $fileType }}', '{{ $title }}')">
                                <i class="fas fa-plus me-2"></i>Tải lên {{ $title }}
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
        </div>
    </div>
    <div class="card-footer bg-light border-top">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Tổng số file {{ $title }}: <span class="fw-semibold">{{ $filteredFiles->count() }}</span>
            </small>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="location.reload()" title="Làm mới">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadPlHdtl1Modal" onclick="setPlHdtl1FileType('{{ $fileType }}', '{{ $title }}')" title="Thêm mới">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
    
</div>

<script>
function confirmDeletePlHdtl1(id) {
    if (confirm('Bạn có chắc chắn muốn xóa file PL HĐTL1 này? Hành động này không thể hoàn tác!')) {
        const button = document.querySelector(`button[data-file-id="${id}"][onclick*="confirmDeletePlHdtl1"]`);
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        const deleteUrl = `{{ route('enrollment_student.delete_pl_hdtl1_file', '') }}/${id}`;

        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                const row = button.closest('tr');
                if (row) {
                    row.style.transition = 'opacity .4s ease';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 400);
                }
            } else {
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi xóa file: ' + error.message, 'error');
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
}
</script>



