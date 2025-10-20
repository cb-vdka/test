<!-- Modal Upload PL HĐTL2 -->
<div class="modal fade" id="uploadPlHdtl2Modal" tabindex="-1" aria-labelledby="uploadPlHdtl2ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPlHdtl2ModalLabel">
                    <i class="fas fa-upload text-success"></i> Tải lên file PL HĐTL2
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPlHdtl2Form">
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="plHdtl2ClassSelect" class="form-label fw-semibold">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>Chọn lớp <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg" id="plHdtl2ClassSelect" required>
                            <option value="">-- Chọn lớp --</option>
                            @if(isset($classes) && $classes->count() > 0)
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="plHdtl2FileType" class="form-label fw-semibold">
                            <i class="fas fa-tag text-success me-2"></i>Loại file <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg bg-light" id="plHdtl2FileType" readonly>
                        <input type="hidden" id="plHdtl2FileTypeValue">
                    </div>
                    
                    <div class="mb-4">
                        <label for="plHdtl2File" class="form-label fw-semibold">
                            <i class="fas fa-file-upload text-info me-2"></i>File PL HĐTL2 <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg" id="plHdtl2File" accept=".xlsx,.xls,.pdf" required>
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
                                    <input class="form-check-input me-3" type="checkbox" id="plHdtl2PublishImmediately" name="is_public" value="1" style="transform: scale(1.3);">
                                    <label class="form-check-label fw-semibold text-primary fs-6" for="plHdtl2PublishImmediately">
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
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal" onclick="closePlHdtl2Modal('uploadPlHdtl2Modal')">
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

<!-- Modal Update PL HĐTL2 -->
<div class="modal fade" id="updatePlHdtl2Modal" tabindex="-1" aria-labelledby="updatePlHdtl2ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePlHdtl2ModalLabel">
                    <i class="fas fa-edit text-primary"></i> Cập nhật file PL HĐTL2
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePlHdtl2Form">
                <div class="modal-body">
                    <div class="alert alert-warning border-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Lưu ý:</strong> File cũ sẽ bị xóa và thay thế bằng file mới.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="updatePlHdtl2Class" class="form-label fw-semibold">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>Lớp hiện tại
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light" id="updatePlHdtl2Class" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="updatePlHdtl2CurrentFile" class="form-label fw-semibold">
                                    <i class="fas fa-file text-info me-2"></i>File hiện tại
                                </label>
                                <input type="text" class="form-control form-control-lg bg-light" id="updatePlHdtl2CurrentFile" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="updatePlHdtl2File" class="form-label fw-semibold">
                            <i class="fas fa-file-upload text-success me-2"></i>File PL HĐTL2 mới <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg" id="updatePlHdtl2File" accept=".xlsx,.xls,.pdf" required>
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
                                    <input class="form-check-input me-3" type="checkbox" id="updatePlHdtl2PublishImmediately" name="is_public" value="1" style="transform: scale(1.3);">
                                    <label class="form-check-label fw-semibold text-primary fs-6" for="updatePlHdtl2PublishImmediately">
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
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal" onclick="closePlHdtl2Modal('updatePlHdtl2Modal')">
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
// Close modal function
function closePlHdtl2Modal(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.hide();
    }
}

// Set file type for upload modal
function setFileType(fileType, title) {
    document.getElementById('plHdtl2FileType').value = title;
    document.getElementById('plHdtl2FileTypeValue').value = fileType;
    document.getElementById('uploadPlHdtl2ModalLabel').innerHTML = `<i class="fas fa-upload text-success"></i> Tải lên ${title}`;
}

// Open update modal
function openUpdatePlHdtl2Modal(fileId, fileName, fileType) {
    const formEl = document.getElementById('updatePlHdtl2Form');
    formEl.setAttribute('data-file-id', fileId);
    formEl.setAttribute('data-file-type', fileType);

    // Reset form TRƯỚC khi gán lại các giá trị hiển thị
    formEl.reset();

    // Lấy tên lớp trực tiếp từ hàng trong bảng (cột 2)
    const triggerButton = document.querySelector(`button[data-file-id="${fileId}"][onclick*="openUpdatePlHdtl2Modal"]`);
    const row = triggerButton ? triggerButton.closest('tr') : null;
    const classCellEl = row ? row.querySelector('td:nth-child(2) .fw-semibold') : null;
    const className = classCellEl ? classCellEl.textContent : 'Lớp không xác định';
    const classInput = document.getElementById('updatePlHdtl2Class');
    if (classInput) classInput.value = className;
    document.getElementById('updatePlHdtl2CurrentFile').value = fileName;
    
    const modalElement = document.getElementById('updatePlHdtl2Modal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

// Toggle PL HĐTL2 status
function togglePlHdtl2Status(fileId, currentStatus) {
    const newStatus = currentStatus === 'public' ? 'hidden' : 'public';
    const statusText = newStatus === 'public' ? 'công khai' : 'tạm ẩn';
    
    if (confirm(`Bạn có chắc muốn ${statusText} file PL HĐTL2 này?`)) {
        const button = document.querySelector(`button[data-file-id="${fileId}"][onclick*="togglePlHdtl2Status"]`);
        const originalContent = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        
        const toggleUrl = `{{ route('enrollment_student.toggle_pl_hdtl2_status', '') }}/${fileId}`;
        
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
            button.innerHTML = originalContent;
            button.disabled = false;
            
            if (data.success) {
                updatePlHdtl2StatusInTable(fileId, data);
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalContent;
            button.disabled = false;
            showNotification('Có lỗi xảy ra khi cập nhật trạng thái: ' + error.message, 'error');
        });
    }
}

// Update status in table
function updatePlHdtl2StatusInTable(fileId, data) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const toggleButton = row.querySelector(`button[data-file-id="${fileId}"][onclick*="togglePlHdtl2Status"]`);
        if (toggleButton) {
            const statusCell = row.querySelector('td:nth-child(4) span');
            if (statusCell) {
                statusCell.className = `badge ${data.badge_class}`;
                statusCell.innerHTML = `<i class="${data.icon_class}"></i> ${data.status_text}`;
            }
            
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
            
            toggleButton.setAttribute('data-file-status', data.new_status);
            toggleButton.setAttribute('onclick', `togglePlHdtl2Status(this.dataset.fileId, this.dataset.fileStatus)`);
        }
    });
}

// Confirm delete PL HĐTL2
function confirmDeletePlHdtl2(id) {
    if (confirm('Bạn có chắc chắn muốn xóa file PL HĐTL2 này? Hành động này không thể hoàn tác!')) {
        const button = document.querySelector(`button[data-file-id="${id}"][onclick*="confirmDeletePlHdtl2"]`);
        const originalContent = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const token = csrfToken ? csrfToken.getAttribute('content') : '';
        
        const deleteUrl = `{{ route('enrollment_student.delete_pl_hdtl2_file', '') }}/${id}`;
        
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
                removePlHdtl2RowFromTable(id);
                showNotification(data.message, 'success');
                checkIfPlHdtl2TableEmpty();
            } else {
                button.innerHTML = originalContent;
                button.disabled = false;
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalContent;
            button.disabled = false;
            showNotification('Có lỗi xảy ra khi xóa file: ' + error.message, 'error');
        });
    }
}

// Remove row from table
function removePlHdtl2RowFromTable(fileId) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const deleteButton = row.querySelector(`button[data-file-id="${fileId}"][onclick*="confirmDeletePlHdtl2"]`);
        if (deleteButton) {
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';
            
            setTimeout(() => {
                row.remove();
            }, 500);
        }
    });
}

// Check if table is empty
function checkIfPlHdtl2TableEmpty() {
    const tbody = document.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    
    if (rows.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = `
            <td colspan="5" class="text-center py-4">
                <div class="text-muted">
                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                    <p class="mb-0">Chưa có file nào được tải lên</p>
                    <small>Nhấn nút "Tải lên" để bắt đầu</small>
                </div>
            </td>
        `;
        tbody.appendChild(emptyRow);
    }
}

// Function để reload chỉ phần bảng PL HĐTL2
function reloadPlHdtl2Table(fileType) {
    const tableBody = document.getElementById(`plHdtl2TableBody_${fileType}`);
    if (tableBody) {
        // Hiển thị loading
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2 text-muted">Đang cập nhật dữ liệu...</p>
                </td>
            </tr>
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
            const newTableBody = doc.getElementById(`plHdtl2TableBody_${fileType}`);
            
            if (newTableBody) {
                tableBody.innerHTML = newTableBody.innerHTML;
            } else {
                // Fallback: reload toàn trang nếu không tìm thấy
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error reloading PL HĐTL2 table:', error);
            // Fallback: reload toàn trang nếu có lỗi
            location.reload();
        });
    }
}

// Upload PL HĐTL2 form - SINGLE EVENT LISTENER
document.addEventListener('DOMContentLoaded', function() {
    // Only attach once
    const uploadForm = document.getElementById('uploadPlHdtl2Form');
    if (uploadForm && !uploadForm.hasAttribute('data-listener-attached')) {
        uploadForm.setAttribute('data-listener-attached', 'true');
        
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const classId = document.getElementById('plHdtl2ClassSelect').value;
            const fileType = document.getElementById('plHdtl2FileTypeValue').value;
            const file = document.getElementById('plHdtl2File').files[0];
            const publishImmediately = document.getElementById('plHdtl2PublishImmediately').checked;
            
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
                            <i class="fas fa-cloud-upload-alt fa-3x text-success"></i>
                        </div>
                        <h6 class="mb-3 fw-bold">Đang tải lên PL HĐTL2...</h6>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                 role="progressbar" style="width: 0%" id="uploadProgress">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted" id="uploadStatus">Đang chuẩn bị...</small>
                            <small class="text-success fw-bold" id="uploadTimer">00:00</small>
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
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('class_id', classId);
            formData.append('file_type', fileType);
            formData.append('is_public', publishImmediately ? '1' : '0');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const token = csrfToken ? csrfToken.getAttribute('content') : '';
            
            const uploadUrl = `{{ route('enrollment_student.upload_pl_hdtl2_file') }}`;
            
            fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                clearInterval(progressInterval);
                clearInterval(timerInterval);
                
                // Hoàn thành progress bar
                const progressBar = document.getElementById('uploadProgress');
                const statusText = document.getElementById('uploadStatus');
                if (progressBar) progressBar.style.width = '100%';
                if (statusText) statusText.textContent = 'Hoàn tất!';
                
                return response.json();
            })
            .then(data => {
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
                    
                    const modalElement = document.getElementById('uploadPlHdtl2Modal');
                    const modal = new bootstrap.Modal(modalElement);
                    modal.hide();
                    
                    this.reset();
                    
                    // Reload chỉ bảng PL HĐTL2
                    reloadPlHdtl2Table(fileType);
                } else {
                    showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
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
    }
    
    // Update PL HĐTL2 form - SINGLE EVENT LISTENER
    const updateForm = document.getElementById('updatePlHdtl2Form');
    if (updateForm && !updateForm.hasAttribute('data-listener-attached')) {
        updateForm.setAttribute('data-listener-attached', 'true');
        
        updateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fileId = this.getAttribute('data-file-id');
            const fileType = this.getAttribute('data-file-type');
            const newFile = document.getElementById('updatePlHdtl2File').files[0];
            const publishImmediately = document.getElementById('updatePlHdtl2PublishImmediately').checked;
            
            console.log('PL HĐTL2 Update - publishImmediately:', publishImmediately);
            console.log('PL HĐTL2 Update - checkbox element:', document.getElementById('updatePlHdtl2PublishImmediately'));
            
            if (!newFile) {
                showNotification('Vui lòng chọn file mới!', 'warning');
                return;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...';
            submitBtn.disabled = true;
            
            const formData = new FormData();
            formData.append('file', newFile);
            formData.append('is_public', publishImmediately ? '1' : '0');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const token = csrfToken ? csrfToken.getAttribute('content') : '';
            
            const updateUrl = `{{ route('enrollment_student.update_pl_hdtl2_file', '') }}/${fileId}`;
            
            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    
                    const modalElement = document.getElementById('updatePlHdtl2Modal');
                    const modal = new bootstrap.Modal(modalElement);
                    modal.hide();
                    
                    this.reset();
                    
                    // Reload chỉ bảng PL HĐTL2
                    reloadPlHdtl2Table(fileType);
                } else {
                    showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                showNotification('Có lỗi xảy ra khi cập nhật file: ' + error.message, 'error');
            });
        });
    }
    
});
</script>

<style>
</style>
