<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý {{ $title }}</h5>
            @if(isset($classes) && $classes->count() > 0)
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPlHdtl2Modal" onclick="setPlHdtl2FileType('{{ $fileType }}', '{{ $title }}')">
                    <i class="fas fa-plus me-1"></i>Tải lên {{ $title }}
                </button>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="plHdtl2Table_{{ $fileType }}" tabindex="0" style="outline: none;">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center py-3">#</th>
                        <th width="25%" class="py-3">Lớp học</th>
                        <th width="35%" class="py-3">File {{ $title }}</th>
                        <th width="15%" class="text-center py-3">Trạng thái</th>
                        <th width="20%" class="text-center py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody id="plHdtl2TableBody_{{ $fileType }}">
            @php
                $filteredFiles = isset($plHdtl2Files) ? $plHdtl2Files->where('file_type', $fileType) : collect();
            @endphp
            
            @if($filteredFiles->count() > 0)
                @foreach($filteredFiles as $index => $file)
                    <tr class="align-middle" data-class-id="{{ $file->class_id }}" data-file-id="{{ $file->id }}">
                        <td class="text-center py-3">
                            <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold text-dark">{{ $file->class->name ?? 'N/A' }}</div>
                            <small class="text-muted">Lớp học</small>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">{{ $file->file_name }}</div>
                                    <small class="text-muted">{{ $file->formatted_file_size }}</small>
                                </div>
                                <a href="/teacher/enrollment_student/download-pl-hdtl2-file/{{ $file->id }}" class="btn btn-outline-success btn-sm" title="Tải xuống">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                        <td class="text-center py-3">
                            @if($file->status === 'public')
                                <span class="badge status-badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="fas fa-eye me-1"></i>Công khai
                                </span>
                            @else
                                <span class="badge status-badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="fas fa-eye-slash me-1"></i>Tạm ẩn
                                </span>
                            @endif
                        </td>
                        <td class="text-center py-3">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" title="Cập nhật" data-file-id="{{ $file->id }}" data-file-name="{{ $file->file_name }}" data-file-type="{{ $file->file_type }}" onclick="openUpdatePlHdtl2Modal(this.dataset.fileId, this.dataset.fileName, this.dataset.fileType)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" title="Công khai/Tạm ẩn" data-file-id="{{ $file->id }}" data-file-status="{{ $file->status }}" onclick="togglePlHdtl2Status(this.dataset.fileId, this.dataset.fileStatus)">
                                    @if($file->status === 'public')
                                        <i class="fas fa-eye-slash"></i>
                                    @else
                                        <i class="fas fa-eye"></i>
                                    @endif
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Xóa" data-file-id="{{ $file->id }}" onclick="confirmDeletePlHdtl2(this.dataset.fileId)">
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
                            <p class="text-muted mb-0">Hãy tải lên file {{ $title }} đầu tiên để bắt đầu.</p>
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
                @if(isset($classes) && $classes->count() > 0)
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadPlHdtl2Modal" onclick="setPlHdtl2FileType('{{ $fileType }}', '{{ $title }}')" title="Thêm mới">
                        <i class="fas fa-plus"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
    
</div>

<script>
// ==================== NOTIFICATION FUNCTION ====================

function showNotification(message, type = 'info') {
    // Tạo toast container nếu chưa có
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Tạo toast element
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white border-0';
    
    // Set màu theo type
    let bgColor = 'bg-primary';
    let icon = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            bgColor = 'bg-success';
            icon = 'fas fa-check-circle';
            break;
        case 'error':
            bgColor = 'bg-danger';
            icon = 'fas fa-exclamation-circle';
            break;
        case 'warning':
            bgColor = 'bg-warning';
            icon = 'fas fa-exclamation-triangle';
            break;
    }
    
    toast.className += ' ' + bgColor;
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i class="${icon} me-2"></i>
                <span>${message}</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Thêm vào container
    toastContainer.appendChild(toast);
    
    // Khởi tạo và hiển thị toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: type === 'error' ? 5000 : 3000
    });
    
    bsToast.show();
    
    // Xóa toast khỏi DOM sau khi ẩn
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
    
    // Hover effect cho nút đóng
    const closeBtn = toast.querySelector('.btn-close');
    closeBtn.addEventListener('mouseenter', function() {
        this.style.opacity = '1';
        this.style.transform = 'scale(1.1)';
    });
    closeBtn.addEventListener('mouseleave', function() {
        this.style.opacity = '0.8';
        this.style.transform = 'scale(1)';
    });
}

// ==================== PL HĐTL2 MANAGEMENT FUNCTIONS ====================

function togglePlHdtl2Status(fileId, currentStatus) {
    const newStatus = currentStatus === 'public' ? 'hidden' : 'public';
    const statusText = newStatus === 'public' ? 'công khai' : 'tạm ẩn';
    
    if (confirm(`Bạn có chắc muốn ${statusText} file PL HĐTL2 này?`)) {
        // Tìm button để hiển thị loading
        const button = document.querySelector(`button[data-file-id="${fileId}"][onclick*="togglePlHdtl2Status"]`);
        const originalContent = button ? button.innerHTML : '';
        
        // Hiển thị loading
        if (button) {
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
        }
        
        // Lấy CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        
        // Gọi API
        const toggleUrl = `/teacher/enrollment_student/toggle-pl-hdtl2-status/${fileId}`;
        
        fetch(toggleUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
                // Reset toàn trang để đồng bộ chắc chắn
                setTimeout(() => window.location.reload(), 200);
        } else {
            showNotification(data.message, 'error');
            if (button) button.innerHTML = originalContent;
        }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi cập nhật trạng thái!', 'error');
            if (button) button.innerHTML = originalContent;
        })
        .finally(() => {
            if (button) button.disabled = false;
        });
    }
}

function confirmDeletePlHdtl2(id) {
    if (confirm('Bạn có chắc chắn muốn xóa file PL HĐTL2 này? Hành động này không thể hoàn tác!')) {
        // Tìm button để hiển thị loading
        const button = document.querySelector(`button[data-file-id="${id}"][onclick*="confirmDeletePlHdtl2"]`);
        const originalContent = button ? button.innerHTML : '';
        
        // Hiển thị loading
        if (button) {
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
        }
        
        // Lấy CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        
        // Gọi API
        const deleteUrl = `/teacher/enrollment_student/delete-pl-hdtl2-file/${id}`;
        
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Reset toàn trang để đồng bộ chắc chắn
                setTimeout(() => window.location.reload(), 300);
            } else {
                showNotification(data.message, 'error');
                if (button) button.innerHTML = originalContent;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi xóa file!', 'error');
            if (button) button.innerHTML = originalContent;
        })
        .finally(() => {
            if (button) button.disabled = false;
        });
    }
}

function openUpdatePlHdtl2Modal(fileId, fileName, fileType) {
    document.getElementById('updatePlHdtl2CurrentFile').value = fileName;
    document.getElementById('updatePlHdtl2Form').setAttribute('data-file-id', fileId);
    document.getElementById('updatePlHdtl2Form').setAttribute('data-file-type', fileType);
    
    // Tìm class name từ table row
    const row = document.querySelector(`button[data-file-id="${fileId}"]`).closest('tr');
    const className = row ? row.querySelector('td:nth-child(2) .fw-semibold').textContent : 'Lớp không xác định';
    document.getElementById('updatePlHdtl2Class').value = className;
    
    // Set file type từ tab hiện tại
    document.getElementById('updatePlHdtl2FileType').value = fileType;
    document.getElementById('updatePlHdtl2FileTypeValue').value = fileType;
    
    const modalElement = document.getElementById('updatePlHdtl2Modal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}
</script>



