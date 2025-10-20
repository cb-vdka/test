<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Quản lý phiếu điểm</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#uploadScoreSheetModal">
                <i class="fas fa-plus me-1"></i>Thêm mới
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
                        <th width="35%" class="py-3">File điểm</th>
                        <th width="15%" class="text-center py-3">Trạng thái</th>
                        <th width="20%" class="text-center py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody id="scoreSheetsTableBody">
            @if(isset($scoreSheets) && $scoreSheets->count() > 0)
                @foreach($scoreSheets as $scoreSheet)
                    <tr class="align-middle">
                        <td class="text-center py-3">
                            <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold text-dark">{{ $scoreSheet->class->name ?? 'N/A' }}</div>
                            <small class="text-muted">Lớp học</small>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">{{ $scoreSheet->file_name }}</div>
                                    <small class="text-muted">{{ $scoreSheet->formatted_file_size }}</small>
                                </div>
                                <a href="/wp-admin/enrollment_student/download-score-sheet/{{ $scoreSheet->id }}" class="btn btn-outline-success btn-sm" title="Tải xuống">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                        <td class="text-center py-3">
                            @if($scoreSheet->status === 'public')
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
                                <button type="button" class="btn btn-outline-primary btn-sm" title="Cập nhật" data-file-id="{{ $scoreSheet->id }}" data-file-name="{{ $scoreSheet->file_name }}" onclick="openUpdateModal(this.dataset.fileId, this.dataset.fileName)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" title="Công khai/Tạm ẩn" data-file-id="{{ $scoreSheet->id }}" data-file-status="{{ $scoreSheet->status }}" onclick="toggleStatus(this.dataset.fileId, this.dataset.fileStatus)">
                                    @if($scoreSheet->status === 'public')
                                        <i class="fas fa-eye-slash"></i>
                                    @else
                                        <i class="fas fa-eye"></i>
                                    @endif
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Xóa" data-file-id="{{ $scoreSheet->id }}" onclick="confirmDelete(this.dataset.fileId)">
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
                            <h5 class="text-muted">Chưa có phiếu điểm nào</h5>
                            <p class="text-muted mb-3">Hãy tải lên phiếu điểm đầu tiên để bắt đầu</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadScoreSheetModal">
                                <i class="fas fa-plus me-2"></i>Tải lên phiếu điểm
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
                Tổng số phiếu điểm: <span class="fw-semibold">{{ isset($scoreSheets) ? $scoreSheets->count() : 0 }}</span>
            </small>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="location.reload()" title="Làm mới">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadScoreSheetModal" title="Thêm mới">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
    
</div>

{{-- Modal xác nhận xóa --}}
<div class="modal fade" id="deleteScoreSheetModal" tabindex="-1" aria-labelledby="deleteScoreSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteScoreSheetModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger"></i>
                </div>
                <h5 class="text-dark mb-3">Bạn có chắc chắn muốn xóa?</h5>
                <p class="text-muted mb-0">Phiếu điểm này sẽ bị xóa vĩnh viễn và không thể khôi phục.</p>
            </div>
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal tải lên phiếu điểm --}}
<div class="modal fade" id="uploadScoreSheetModal" tabindex="-1" aria-labelledby="uploadScoreSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadScoreSheetModalLabel">
                    <i class="fas fa-upload text-success"></i> Tải lên phiếu điểm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadScoreSheetForm">
                 <div class="modal-body">
                     <div class="mb-4">
                         <label for="classSelect" class="form-label fw-semibold">
                             <i class="fas fa-graduation-cap text-primary me-2"></i>Chọn lớp <span class="text-danger">*</span>
                         </label>
                         <select class="form-select form-select-lg" id="classSelect" required>
                             <option value="">-- Chọn lớp --</option>
                             @if(isset($classes) && $classes->count() > 0)
                                 @foreach($classes as $class)
                                     <option value="{{ $class->id }}">{{ $class->name }}</option>
                                 @endforeach
                             @else
                                 <option value="1">Lớp CNTT01</option>
                                 <option value="2">Lớp CNTT02</option>
                                 <option value="3">Lớp KTPM01</option>
                                 <option value="4">Lớp KTPM02</option>
                             @endif
                         </select>
                     </div>
                    <div class="mb-4">
                        <label for="scoreFile" class="form-label fw-semibold">
                            <i class="fas fa-file-upload text-info me-2"></i>File phiếu điểm <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg" id="scoreFile" accept=".xlsx,.xls,.pdf" required>
                        <div class="form-text mt-2">
                            <div class="alert alert-info py-2 px-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Chấp nhận file Excel (.xlsx, .xls) hoặc PDF (.pdf). Kích thước tối đa: 10MB
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="card border-primary">
                            <div class="card-body py-3">
                                <div class="form-check">
                                    <input class="form-check-input me-3" type="checkbox" id="publishImmediately" name="is_public" value="1" style="transform: scale(1.3);">
                                    <label class="form-check-label fw-semibold text-primary fs-6" for="publishImmediately">
                                        <i class="fas fa-eye me-2"></i>Công khai ngay sau khi tải lên
                                    </label>
                                </div>
                                <small class="text-muted ms-5 d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>File sẽ được hiển thị công khai ngay lập tức
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal" onclick="closeScoreSheetModal('uploadScoreSheetModal')">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-upload me-2"></i>Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal cập nhật phiếu điểm --}}
<div class="modal fade" id="updateScoreSheetModal" tabindex="-1" aria-labelledby="updateScoreSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateScoreSheetModalLabel">
                    <i class="fas fa-edit text-primary"></i> Cập nhật phiếu điểm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateScoreSheetForm">
                <div class="modal-body">
                    <div class="alert alert-warning border-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Lưu ý:</strong> File cũ sẽ bị xóa và thay thế bằng file mới.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="updateClassSelect" class="form-label fw-semibold">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>Lớp hiện tại
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light" id="updateClassSelect" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="updateCurrentFile" class="form-label fw-semibold">
                                    <i class="fas fa-file text-info me-2"></i>File hiện tại
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light" id="updateCurrentFile" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="updateScoreFile" class="form-label fw-semibold">
                            <i class="fas fa-file-upload text-success me-2"></i>File phiếu điểm mới <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg" id="updateScoreFile" accept=".xlsx,.xls,.pdf" required>
                        <div class="form-text mt-2">
                            <div class="alert alert-info py-2 px-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Chấp nhận file Excel (.xlsx, .xls) hoặc PDF (.pdf). Kích thước tối đa: 10MB
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="card border-primary">
                            <div class="card-body py-3">
                                <div class="form-check">
                                    <input class="form-check-input me-3" type="checkbox" id="updatePublishImmediately" name="is_public" value="1" style="transform: scale(1.3);">
                                    <label class="form-check-label fw-semibold text-primary fs-6" for="updatePublishImmediately">
                                        <i class="fas fa-eye me-2"></i>Công khai ngay sau khi cập nhật
                                    </label>
                                </div>
                                <small class="text-muted ms-5 d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>File sẽ được hiển thị công khai ngay lập tức
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal" onclick="closeScoreSheetModal('updateScoreSheetModal')">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa phiếu điểm này? Hành động này không thể hoàn tác!')) {
        const button = document.querySelector(`button[data-file-id="${id}"][onclick*="confirmDelete"]`);
        const originalContent = button ? button.innerHTML : '';
        if (button) {
            button.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i>';
            button.disabled = true;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        const deleteUrl = `{{ route('enrollment_student.delete_score_sheet', '') }}/${id}`;
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
                removeRowFromTable(id);
                showNotification(data.message, 'success');
                checkIfTableEmpty();
            } else {
                if (button) { button.innerHTML = originalContent; button.disabled = false; }
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (button) { button.innerHTML = originalContent; button.disabled = false; }
            showNotification('Có lỗi xảy ra khi xóa phiếu điểm: ' + error.message, 'error');
        });
    }
}

// Function để xóa row khỏi bảng
function removeRowFromTable(scoreSheetId) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const deleteButton = row.querySelector(`button[data-file-id="${scoreSheetId}"][onclick*="confirmDelete"]`);
        if (deleteButton) {
            // Thêm hiệu ứng fade out
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';
            
            // Xóa row sau khi fade out
            setTimeout(() => {
                row.remove();
                console.log('Removed row for score sheet ID:', scoreSheetId);
            }, 500);
        }
    });
}

// Function để kiểm tra nếu bảng trống
function checkIfTableEmpty() {
    const tbody = document.getElementById('scoreSheetsTableBody');
    const rows = tbody.querySelectorAll('tr');
    
    // Nếu không còn row nào, hiển thị empty state
    if (rows.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = `
            <td colspan="5" class="text-center py-4">
                <div class="text-muted">
                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                    <p class="mb-0">Chưa có phiếu điểm nào được tải lên</p>
                    <small>Nhấn nút "Tải lên phiếu điểm" để bắt đầu</small>
                </div>
            </td>
        `;
        tbody.appendChild(emptyRow);
    }
}

function showNotification(message, type = 'info') {
    // Tạo thông báo toast
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    // Thêm vào container toast
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Hiển thị toast
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Tự động xóa sau khi ẩn
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

// Xử lý form tải lên
document.getElementById('uploadScoreSheetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const classId = document.getElementById('classSelect').value;
    const file = document.getElementById('scoreFile').files[0];
    const publishImmediately = document.getElementById('publishImmediately').checked;
    
    if (!classId) {
        showNotification('Vui lòng chọn lớp!', 'warning');
        return;
    }
    
    if (!file) {
        showNotification('Vui lòng chọn file!', 'warning');
        return;
    }
    
    // Hiển thị loading với progress bar
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Tạo progress container
    const progressContainer = document.createElement('div');
    progressContainer.className = 'position-fixed top-50 start-50 translate-middle';
    progressContainer.style.zIndex = '10000';
    progressContainer.style.minWidth = '300px';
    progressContainer.innerHTML = `
        <div class="card shadow-lg border-0">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                </div>
                <h6 class="mb-3 fw-bold">Đang tải lên phiếu điểm...</h6>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                         role="progressbar" style="width: 0%" id="uploadProgress">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted" id="uploadStatus">Đang chuẩn bị...</small>
                    <small class="text-primary fw-bold" id="uploadTimer">00:00</small>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(progressContainer);
    
    // Cập nhật button
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tải lên...';
    submitBtn.disabled = true;
    
    // Timer và progress
    let startTime = Date.now();
    let progress = 0;
    let progressInterval;
    let timerInterval;
    
    // Cập nhật timer
    timerInterval = setInterval(() => {
        const elapsed = Math.floor((Date.now() - startTime) / 1000);
        const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
        const seconds = (elapsed % 60).toString().padStart(2, '0');
        document.getElementById('uploadTimer').textContent = `${minutes}:${seconds}`;
    }, 1000);
    
    // Simulate progress
    progressInterval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 90) progress = 90; // Dừng ở 90% chờ response
        
        const progressBar = document.getElementById('uploadProgress');
        const statusText = document.getElementById('uploadStatus');
        
        if (progress < 30) {
            statusText.textContent = 'Đang xử lý file...';
        } else if (progress < 60) {
            statusText.textContent = 'Đang kiểm tra quyền...';
        } else if (progress < 90) {
            statusText.textContent = 'Đang lưu file...';
        } else {
            statusText.textContent = 'Đang hoàn tất...';
        }
        
        progressBar.style.width = progress + '%';
    }, 200);
    
    // Chuẩn bị FormData
    const formData = new FormData();
    formData.append('file', file);
    formData.append('class_id', classId);
    formData.append('is_public', publishImmediately ? '1' : '0');
    
    // Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';
    
    // Endpoint Laravel
    const uploadUrl = `{{ route('enrollment_student.upload_score_sheet') }}`;
    console.log('Uploading file:', uploadUrl);
    
    // Timeout để tránh load vô hạn
    const timeoutId = setTimeout(() => {
        // Cleanup progress
        clearInterval(progressInterval);
        clearInterval(timerInterval);
        if (progressContainer && progressContainer.parentNode) {
            progressContainer.remove();
        }
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        showNotification('Request timeout! Vui lòng thử lại.', 'error');
    }, 30000);
    
    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        clearTimeout(timeoutId);
        clearInterval(progressInterval);
        clearInterval(timerInterval);
        
        // Hoàn thành progress bar
        const progressBar = document.getElementById('uploadProgress');
        const statusText = document.getElementById('uploadStatus');
        if (progressBar) progressBar.style.width = '100%';
        if (statusText) statusText.textContent = 'Hoàn tất!';
        
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        // Cleanup progress container
        setTimeout(() => {
            if (progressContainer && progressContainer.parentNode) {
                progressContainer.remove();
            }
        }, 500);
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Đóng modal
            const modalElement = document.getElementById('uploadScoreSheetModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.hide();
            
            // Reset form
            this.reset();
            
            // Reload toàn trang ngay lập tức
            location.reload();
        } else {
            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
        }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        clearInterval(progressInterval);
        clearInterval(timerInterval);
        
        // Cleanup progress container
        if (progressContainer && progressContainer.parentNode) {
            progressContainer.remove();
        }
        
        console.error('Error:', error);
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        showNotification('Có lỗi xảy ra khi tải lên file: ' + error.message, 'error');
    });
});

// Function để reload chỉ phần bảng điểm
function reloadScoreSheetsTable() {
    const tableContainer = document.getElementById('scoreSheetsTableContainer');
    if (tableContainer) {
        // Hiển thị loading
        tableContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
                <p class="mt-2 text-muted">Đang cập nhật dữ liệu...</p>
            </div>
        `;
        
        // Gọi AJAX để lấy lại nội dung bảng
        fetch(window.location.href, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Tạo DOM parser để extract chỉ phần bảng
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.getElementById('scoreSheetsTableContainer');
            
            if (newTableContainer) {
                tableContainer.innerHTML = newTableContainer.innerHTML;
            } else {
                // Fallback: reload toàn trang nếu không tìm thấy
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error reloading table:', error);
            // Fallback: reload toàn trang nếu có lỗi
            location.reload();
        });
    }
}

// Close modal function
function closeScoreSheetModal(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.hide();
    }
}

// Function để mở modal cập nhật
function openUpdateModal(fileId, currentFileName) {
    try {
        console.log('Opening update modal for file:', fileId, currentFileName);
        
        // Lấy tên lớp trực tiếp từ bảng (cột 2) của hàng chứa nút đã bấm
        const triggerButton = document.querySelector(`button[data-file-id="${fileId}"][onclick*="openUpdateModal"]`);
        const row = triggerButton ? triggerButton.closest('tr') : null;
        const classCellEl = row ? row.querySelector('td:nth-child(2) .fw-semibold') : null;
        const className = classCellEl ? classCellEl.textContent : 'Lớp không xác định';
        
        // Kiểm tra elements có tồn tại không
        const classSelect = document.getElementById('updateClassSelect');
        const currentFile = document.getElementById('updateCurrentFile');
        const form = document.getElementById('updateScoreSheetForm');
        const modalElement = document.getElementById('updateScoreSheetModal');
        
        if (!classSelect || !currentFile || !form || !modalElement) {
            console.error('Modal elements not found!');
            showNotification('Lỗi: Không tìm thấy modal elements!', 'error');
            return;
        }
        
        // Điền thông tin
        classSelect.value = className;
        currentFile.value = currentFileName;
        
        // Reset form nhưng giữ lại thông tin đã điền
        form.reset();
        classSelect.value = className;
        currentFile.value = currentFileName;
        
        // Lưu fileId
        form.setAttribute('data-file-id', fileId);
        
        // Mở modal - sử dụng cách đơn giản hơn
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        
        console.log('Modal opened successfully');
        
    } catch (error) {
        console.error('Error opening update modal:', error);
        showNotification('Lỗi khi mở modal: ' + error.message, 'error');
    }
}


// Xử lý form cập nhật
document.getElementById('updateScoreSheetForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const fileId = this.getAttribute('data-file-id');
    const newFile = document.getElementById('updateScoreFile').files[0];
    const publishImmediately = document.getElementById('updatePublishImmediately').checked;

    if (!newFile) {
        showNotification('Vui lòng chọn file mới!', 'warning');
        return;
    }

    // Hiển thị loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...';
    submitBtn.disabled = true;

    // Chuẩn bị FormData
    const formData = new FormData();
    formData.append('file', newFile);
    formData.append('is_public', publishImmediately ? '1' : '0');

    // Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';

    // Endpoint Laravel
    const updateUrl = `{{ route('enrollment_student.update_score_sheet', '') }}/${fileId}`;
    console.log('Updating file:', fileId, 'URL:', updateUrl);

    // Timeout để tránh load vô hạn
    const timeoutId = setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        showNotification('Request timeout! Vui lòng thử lại.', 'error');
    }, 30000);

    // 🧠 Quan trọng: KHÔNG thêm Content-Type khi dùng FormData
    fetch(updateUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        clearTimeout(timeoutId);
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);

        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;

         if (data.success) {
             showNotification(data.message, 'success');
             
             // Đóng modal - sử dụng cách đơn giản hơn
             const modalElement = document.getElementById('updateScoreSheetModal');
             const modal = new bootstrap.Modal(modalElement);
             modal.hide();
             
             this.reset();

             // Reload chỉ phần bảng điểm sau 1 giây
             setTimeout(() => {
                 reloadScoreSheetsTable();
             }, 1000);
         } else {
             showNotification(data.message || 'Có lỗi xảy ra!', 'error');
         }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        console.error('Error:', error);

        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        showNotification('Có lỗi xảy ra khi cập nhật file: ' + error.message, 'error');
    });
});

// Khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', function() {
    // Attach download event listeners
    attachDownloadListeners();
});

// Function để toggle status (công khai/tạm ẩn)
function toggleStatus(scoreSheetId, currentStatus) {
    const newStatus = currentStatus === 'public' ? 'hidden' : 'public';
    const statusText = newStatus === 'public' ? 'công khai' : 'tạm ẩn';
    
    if (confirm(`Bạn có chắc muốn ${statusText} phiếu điểm này?`)) {
        // Tìm button để hiển thị loading
        const button = document.querySelector(`button[data-file-id="${scoreSheetId}"][onclick*="toggleStatus"]`);
        const originalContent = button.innerHTML;
        
        // Hiển thị loading
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Lấy CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        
        // Gọi API
        const toggleUrl = `{{ route('enrollment_student.toggle_status', '') }}/${scoreSheetId}`;
        
        fetch(toggleUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Khôi phục button
            button.innerHTML = originalContent;
            button.disabled = false;
            
            if (data.success) {
                // Cập nhật UI
                updateStatusInTable(scoreSheetId, data);
                
                // Hiển thị thông báo
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Khôi phục button
            button.innerHTML = originalContent;
            button.disabled = false;
            
            showNotification('Có lỗi xảy ra khi cập nhật trạng thái: ' + error.message, 'error');
        });
    }
}

// Function để cập nhật status trong bảng
function updateStatusInTable(scoreSheetId, data) {
    // Tìm row chứa score sheet
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const toggleButton = row.querySelector(`button[data-file-id="${scoreSheetId}"][onclick*="toggleStatus"]`);
        if (toggleButton) {
            // Cập nhật badge status
            const statusCell = row.querySelector('td:nth-child(4) span');
            if (statusCell) {
                statusCell.className = `badge ${data.badge_class}`;
                statusCell.innerHTML = `<i class="${data.icon_class}"></i> ${data.status_text}`;
            }
            
            // Cập nhật icon của toggle button
            const icon = toggleButton.querySelector('i');
            if (icon) {
                if (data.new_status === 'public') {
                    icon.className = 'fas fa-eye-slash';
                    toggleButton.title = 'Tạm ẩn';
                } else {
                    icon.className = 'fas fa-eye';
                    toggleButton.title = 'Công khai';
                }
            }
            
            // Cập nhật onclick attribute
            toggleButton.setAttribute('data-file-status', data.new_status);
            toggleButton.setAttribute('onclick', `toggleStatus(this.dataset.fileId, this.dataset.fileStatus)`);
            
            console.log('Updated status in table for ID:', scoreSheetId, 'to:', data.new_status);
        }
    });
}

// Function để attach download event listeners
function attachDownloadListeners() {
    const downloadLinks = document.querySelectorAll('.download-file');
    
    downloadLinks.forEach(link => {
        // Remove existing listeners
        link.removeEventListener('click', handleDownload);
        // Add new listener
        link.addEventListener('click', handleDownload);
        
        // Thêm hiệu ứng hover
        link.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.borderRadius = '5px';
            this.style.padding = '5px';
            this.style.cursor = 'pointer';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
            this.style.padding = '0';
        });
    });
}

// Function để xử lý download
function handleDownload(e) {
    e.preventDefault();
    
    const fileId = this.getAttribute('data-file-id');
    const fileName = this.getAttribute('data-file-name');
    
    // Hiển thị loading
    const originalContent = this.innerHTML;
    this.innerHTML = '<div class="d-flex align-items-center"><i class="fas fa-spinner fa-spin text-primary me-2"></i><span class="text-primary">Đang tải xuống...</span></div>';
    
    // Gọi API download file thực tế
    const downloadUrl = `/wp-admin/enrollment_student/download-score-sheet/${fileId}`;
    
    // Tạo link ẩn để download
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = fileName;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Khôi phục nội dung gốc sau 1 giây
    setTimeout(() => {
        this.innerHTML = originalContent;
        showNotification(`Đã tải xuống file: ${fileName}`, 'success');
    }, 1000);
}


</script>

<style>
</style>
