<div class="page-inner">
    @include('admin.dashboard.components.breadcrumb')

    @php
        $url = $config['method'] == 'create' ? route('teaching_schedule.store') : route('teaching_schedule.update', $getEdit->id ?? 1);
        $title = $config['method'] == 'create' ? 'Thêm mới lịch dạy' : 'Chỉnh sửa lịch dạy';
    @endphp

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title float-left">{{ $title }}</h4>
                <a href="{{ route('teaching_schedule.index') }}" class="btn btn-sm btn-primary">Quay lại danh sách</a>
            </div>
            <div class="card-body">
                <form id="scheduleForm" action="{{ $url }}" method="POST" autocomplete="on">
                    @csrf
                    @if($config['method'] == 'edit')
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            @include('admin.teaching_schedule.teaching_schedule.components.general')
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mb10 button-fix" name="send"
                                value="send" id="submitBtn">
                                <span class="btn-text">Lưu</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('scheduleForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable button and show spinner
            submitBtn.disabled = true;
            btnText.textContent = 'Đang lưu...';
            spinner.classList.remove('d-none');
            
            // Get form data
            const formData = new FormData(form);
            
            // Submit via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message || 'Thêm lịch dạy thành công');
                    } else {
                        alert(data.message || 'Thêm lịch dạy thành công');
                    }
                    
                    // Reset form (giữ ngày hiện tại, reset Select2)
                    var keepDate = document.getElementById('schedule_date') ? document.getElementById('schedule_date').value : '';
                    form.reset();
                    if (keepDate) { try { document.getElementById('schedule_date').value = keepDate; } catch(_) {} }
                    try { $('#class_id').val(null).trigger('change'); } catch(_) {}
                    try { $('#subject_id').val(null).trigger('change'); } catch(_) {}
                    try { $('#teacher_id').val(null).trigger('change'); } catch(_) {}
                    try { $('#school_shift_id').val(null).trigger('change'); } catch(_) {}
                    try { $('#room_id').val(null).trigger('change'); } catch(_) {}
                    
                    // Show success message and redirect smoothly
                    setTimeout(() => {
                        // Add a smooth transition effect
                        document.body.style.opacity = '0.8';
                        document.body.style.transition = 'opacity 0.3s ease';
                        
                        setTimeout(() => {
                            window.location.href = '{{ route("teaching_schedule.index") }}';
                        }, 300);
                    }, 1500);
                    
                } else {
                    // Show error message
                    if (typeof toastr !== 'undefined') {
                        toastr.error(data.message || 'Có lỗi xảy ra khi thêm lịch dạy');
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi thêm lịch dạy');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Có lỗi xảy ra khi thêm lịch dạy');
                } else {
                    alert('Có lỗi xảy ra khi thêm lịch dạy');
                }
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                btnText.textContent = 'Lưu';
                spinner.classList.add('d-none');
            });
        });
    }
});
</script>
