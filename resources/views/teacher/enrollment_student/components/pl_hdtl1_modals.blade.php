@if(isset($classes) && $classes->count() > 0)
<!-- Modal Upload PL HĐTL1 (Teacher) -->
<div class="modal fade" id="uploadPlHdtl1Modal" tabindex="-1" aria-labelledby="uploadPlHdtl1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPlHdtl1ModalLabel">
                    <i class="fas fa-upload text-success"></i> Tải lên file PL HĐTL1
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPlHdtl1Form">
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="plHdtl1ClassSelect" class="form-label fw-semibold">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>Chọn lớp <span class="text-danger">*</span>
                        </label>
                        @if(isset($classes) && $classes && $classes->count() > 0)
                            <select class="form-select form-select-lg" id="plHdtl1ClassSelect" required>
                                <option value="">-- Chọn lớp --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-select form-select-lg" id="plHdtl1ClassSelect" disabled>
                                <option value="">Tài khoản của bạn chưa được phân công lớp</option>
                            </select>
                            <div class="form-text mt-2">
                                <div class="alert alert-warning py-2 px-3 mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Bạn chưa có lớp để thao tác. Vui lòng liên hệ quản trị viên để được phân công lớp.
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label for="plHdtl1FileType" class="form-label fw-semibold">
                            <i class="fas fa-tag text-success me-2"></i>Loại file <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg bg-light" id="plHdtl1FileType" readonly>
                        <input type="hidden" id="plHdtl1FileTypeValue">
                    </div>
                    
                    <div class="mb-4">
                        <label for="plHdtl1File" class="form-label fw-semibold">
                            <i class="fas fa-file-upload text-info me-2"></i>File PL HĐTL1 <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control form-control-lg" id="plHdtl1File" accept=".xlsx,.xls,.pdf" required>
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
                                    <input class="form-check-input me-3" type="checkbox" id="plHdtl1PublishImmediately" name="is_public" value="1" style="transform: scale(1.3);">
                                    <label class="form-check-label fw-semibold text-primary fs-6" for="plHdtl1PublishImmediately">
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
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-success btn-lg" @if(!(isset($classes) && $classes && $classes->count() > 0)) disabled @endif>
                        <i class="fas fa-upload me-2"></i>Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update PL HĐTL1 Modal -->
<div class="modal fade" id="updatePlHdtl1Modal" tabindex="-1" aria-labelledby="updatePlHdtl1ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePlHdtl1ModalLabel">
                    <i class="fas fa-edit text-primary"></i> Cập nhật file PL HĐTL1
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePlHdtl1Form" enctype="multipart/form-data" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger border-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Cảnh báo:</strong> File cũ sẽ bị xóa vĩnh viễn và thay thế bằng file mới. Hành động này không thể hoàn tác!
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="updatePlHdtl1Class" class="form-label">
                                    <i class="fas fa-graduation-cap text-primary me-1"></i>Lớp hiện tại
                                </label>
                                <input type="text" class="form-control bg-light" id="updatePlHdtl1Class" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-file text-info me-1"></i>File hiện tại
                                </label>
                                <input type="text" class="form-control bg-light" id="updatePlHdtl1CurrentFile" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="updatePlHdtl1FileType" class="form-label">
                            <i class="fas fa-tags text-warning me-1"></i>Loại file
                        </label>
                        <input type="text" class="form-control bg-light" id="updatePlHdtl1FileType" readonly>
                        <input type="hidden" id="updatePlHdtl1FileTypeValue" name="file_type">
                    </div>
                    
                    <div class="mb-3">
                        <label for="updatePlHdtl1File" class="form-label">
                            <i class="fas fa-upload text-success me-1"></i>File mới
                        </label>
                        <input type="file" class="form-control" id="updatePlHdtl1File" name="file" accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx" required>
                        <div class="form-text">Chấp nhận file PDF, Word, Excel, PowerPoint. Tối đa 10MB.</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="updatePlHdtl1IsPublic" name="is_public">
                            <label class="form-check-label" for="updatePlHdtl1IsPublic">
                                <i class="fas fa-eye text-success me-1"></i>Công khai ngay sau khi tải lên
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Function để reload chỉ bảng PL HĐTL1
function reloadPlHdtl1Table() {
    // Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';
    
    // Tìm tab đang active
    const activeTab = document.querySelector('#plHdtl1TabsContent .tab-pane.active');
    if (!activeTab) {
        console.error('No active PL HĐTL1 tab found');
        return;
    }
    
    // Lấy fileType từ tab đang active
    const fileType = getFileTypeFromActiveTab(activeTab);
    
    // Gọi API để lấy HTML mới của bảng PL HĐTL1
    fetch(`/teacher/enrollment_student/pl-hdtl1-table?fileType=${fileType}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'text/html',
        }
    })
    .then(response => response.text())
    .then(html => {
        // Chỉ thay thế phần table body, giữ nguyên header và nút "Tải lên"
        const tableBody = activeTab.querySelector('#plHdtl1TableBody_' + fileType);
        if (tableBody) {
            // Tạo một div tạm để parse HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Lấy table body từ HTML mới
            const newTableBody = tempDiv.querySelector('#plHdtl1TableBody_' + fileType);
            if (newTableBody) {
                tableBody.innerHTML = newTableBody.innerHTML;
            }
        }
    })
    .catch(error => {
        console.error('Error reloading PL HĐTL1 table:', error);
        // Fallback: reload toàn trang nếu có lỗi
        window.location.reload();
    });
}

// Function để lấy fileType từ tab đang active
function getFileTypeFromActiveTab(activeTab) {
    const tabId = activeTab.id;
    switch(tabId) {
        case 'kqhttx': return 'kqhttx';
        case 'kqrl': return 'kqrl';
        case 'ngay-cong': return 'ngay_cong';
        case 'dieu-chinh': return 'dieu_chinh';
        case 'ren-luyen-kha': return 'ren_luyen_kha';
        case 'hoc-gioi': return 'hoc_gioi';
        default: return 'kqhttx';
    }
}

// Update PL HĐTL1 Form Handler
document.getElementById('updatePlHdtl1Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Confirmation dialog
    if (!confirm('Bạn có chắc chắn muốn cập nhật? File cũ sẽ bị xóa vĩnh viễn và thay thế bằng file mới!')) {
        return;
    }
    
    const formData = new FormData(this);
    const fileInput = document.getElementById('updatePlHdtl1File');
    const newFile = fileInput.files[0];
    
    if (!newFile) {
        showNotification('Vui lòng chọn file để cập nhật!', 'error');
        return;
    }
    
    // Validate file size (10MB max)
    if (newFile.size > 10 * 1024 * 1024) {
        showNotification('File quá lớn! Kích thước tối đa là 10MB.', 'error');
        return;
    }
    
    // Validate file type
    const allowedTypes = [
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-powerpoint'
    ];
    if (!allowedTypes.includes(newFile.type)) {
        showNotification('Chỉ chấp nhận file PDF, Word, Excel, PowerPoint!', 'error');
        return;
    }
    
    // Hiển thị loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...';
    submitBtn.disabled = true;
    
    // Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';
    formData.append('_token', token);
    formData.append('_method', 'PUT'); // Method spoofing for Laravel
    
    // Set action URL
    const fileId = this.getAttribute('data-file-id');
    this.action = `/teacher/enrollment_student/update-pl-hdtl1-file/${fileId}`;
    
    // Gọi API
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token,
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('updatePlHdtl1Modal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset form
            this.reset();
            
            // Reload chỉ bảng PL HĐTL1
            setTimeout(() => reloadPlHdtl1Table(), 300);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi cập nhật file!', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>

<script>
// Function để set file type cho PL HĐTL1
function setPlHdtl1FileType(fileType, title) {
    document.getElementById('plHdtl1FileType').value = title;
    document.getElementById('plHdtl1FileTypeValue').value = fileType;
}

// Function để mở modal update
function openUpdatePlHdtl1Modal(fileId, fileName, fileType) {
    document.getElementById('updatePlHdtl1CurrentFile').value = fileName;
    document.getElementById('updatePlHdtl1Form').setAttribute('data-file-id', fileId);
    document.getElementById('updatePlHdtl1Form').setAttribute('data-file-type', fileType);
    
    // Tìm class name từ table row
    const row = document.querySelector(`button[data-file-id="${fileId}"]`).closest('tr');
    const className = row ? row.querySelector('td:nth-child(2) .fw-semibold').textContent : 'Lớp không xác định';
    document.getElementById('updatePlHdtl1Class').value = className;
    
    // Set file type từ tab hiện tại
    document.getElementById('updatePlHdtl1FileType').value = fileType;
    document.getElementById('updatePlHdtl1FileTypeValue').value = fileType;
    
    const modalElement = document.getElementById('updatePlHdtl1Modal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

// Xử lý form tải lên PL HĐTL1 (Teacher)
document.getElementById('uploadPlHdtl1Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const classId = document.getElementById('plHdtl1ClassSelect').value;
    const file = document.getElementById('plHdtl1File').files[0];
    const fileType = document.getElementById('plHdtl1FileTypeValue').value;
    const publishImmediately = document.getElementById('plHdtl1PublishImmediately').checked;
    
    if (!classId) {
        showNotification('Vui lòng chọn lớp!', 'warning');
        return;
    }
    
    if (!file) {
        showNotification('Vui lòng chọn file!', 'warning');
        return;
    }
    
    if (!fileType) {
        showNotification('Vui lòng chọn loại file!', 'warning');
        return;
    }
    
    // Kiểm tra xem lớp đã có file trong tab hiện tại chưa
    const currentTableBody = document.querySelector('#plHdtl1TableBody_' + fileType);
    if (currentTableBody) {
        const existingRows = currentTableBody.querySelectorAll('tr[data-class-id]');
        for (let row of existingRows) {
            if (row.getAttribute('data-class-id') === classId) {
                showNotification(`Lớp này đã có file PL HĐTL1 (${fileType}). Mỗi lớp chỉ được tải lên 1 file!`, 'error');
                return;
            }
        }
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Chuẩn bị FormData
    const formData = new FormData();
    formData.append('file', file);
    formData.append('class_id', classId);
    formData.append('file_type', fileType);
    formData.append('is_public', publishImmediately ? '1' : '0');
    
    // Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';
    
    // Endpoint Laravel cho teacher
    const uploadUrl = '/teacher/enrollment_student/upload-pl-hdtl1-file';
    console.log('Teacher uploading PL HĐTL1 file:', uploadUrl);
    
    // Timeout để tránh load vô hạn
    const timeoutId = setTimeout(() => {
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
        
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Chỉ reset file input và checkbox, giữ nguyên class và file type
            document.getElementById('plHdtl1File').value = '';
            document.getElementById('plHdtl1PublishImmediately').checked = false;
            
            // Reload chỉ bảng PL HĐTL1
            setTimeout(() => reloadPlHdtl1Table(), 300);
        } else {
            showNotification(data.message || 'Có lỗi xảy ra khi tải lên file PL HĐTL1!', 'error');
        }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        console.error('Upload error:', error);
        showNotification('Lỗi kết nối! Vui lòng thử lại.', 'error');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endif