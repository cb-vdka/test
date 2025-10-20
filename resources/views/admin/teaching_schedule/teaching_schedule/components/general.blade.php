@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-start" role="alert">
        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
        <div>
            <div class="fw-semibold mb-1">Không thể lưu lịch huấn luyện. Vui lòng kiểm tra các trường bên dưới:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        if (typeof toastr !== 'undefined') {
            toastr.clear();
            toastr.error('Không thể lưu vì ca học bị trùng hoặc thiếu thông tin bắt buộc.');
        }
        try { window.scrollTo({ top: 0, behavior: 'smooth' }); } catch(_) {}
    });
    </script>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="class_id">Lớp học <span class="text-danger">(*)</span></label>
            <select name="class_id" id="class_id" class="form-control setupSelect2" required>
                <option value="">-- Chọn lớp học --</option>
                @if(isset($classes))
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" 
                            {{ (string) old('class_id', session('prefill_class_id') ?? ($getEdit->class_id ?? '')) === (string) $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('class_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="subject_id">Môn học <span class="text-danger">(*)</span></label>
            <select name="subject_id" id="subject_id" class="form-control setupSelect2" required>
                <option value="">-- Chọn môn học --</option>
                @if(isset($subjects))
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" 
                            {{ (string) old('subject_id', session('prefill_subject_id') ?? ($getEdit->subject_id ?? '')) === (string) $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('subject_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="teacher_id">Giảng viên <span class="text-danger">(*)</span></label>
            <select class="form-control setupSelect2" id="teacher_id" name="teacher_id" required>
                <option value="">-- Chọn giảng viên --</option>
                @if(isset($teachers))
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" 
                            {{ old('teacher_id', $getEdit->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} - {{ $teacher->code ?? 'N/A' }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('teacher_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="school_shift_id">Ca dạy <span class="text-danger">(*)</span></label>
            <select name="school_shift_id" id="school_shift_id" class="form-control setupSelect2" required>
                <option value="">-- Chọn ca dạy --</option>
                @if(isset($schoolShifts))
                    @foreach($schoolShifts as $shift)
                        <option value="{{ $shift->id }}" 
                            {{ (string) old('school_shift_id', (session('prefill_shift_id') ?? ($getEdit->school_shift_id ?? ''))) === (string) $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                        </option>
                    @endforeach
                @endif
            </select>
            @error('school_shift_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <!-- Chọn địa điểm học -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="room_id">Địa điểm học <span class="text-danger">(*)</span></label>
            <select name="room_id" id="room_id" class="form-control setupSelect2" required>
                <option value="">-- Chọn địa điểm học --</option>
                @if(isset($classrooms))
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" 
                            {{ old('room_id', $getEdit->room_id ?? '') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('room_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Chọn ngày học -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="schedule_date">Ngày học <span class="text-danger">(*)</span></label>
            <input type="date" 
                   class="form-control" 
                   id="schedule_date" 
                   name="schedule_date" 
                   value="{{ old('schedule_date', session('prefill_schedule_date') ?? ($getEdit->schedule_date ?? '')) }}"
                   min="{{ date('Y-m-d') }}"
                   required>
            @error('schedule_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <!-- Hiển thị thứ trong tuần (tự động) -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="day_display">Thứ trong tuần</label>
            <input type="text" 
                   class="form-control" 
                   id="day_display" 
                   readonly 
                   placeholder="Sẽ hiển thị sau khi chọn ngày">
            <input type="hidden" 
                   id="day_of_week" 
                   name="day_of_week" 
                   value="{{ old('day_of_week', $getEdit->day_of_week ?? '') }}">
        </div>
    </div>
</div>

<span id="prefillShiftMeta" data-shift="{{ session('prefill_shift_name') }}" style="display:none"></span>

<!-- Bulk Classes Modal removed as requested -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Teaching schedule form loaded');
    
    // Khởi tạo Select2 cho các dropdown
    $('.setupSelect2').select2({
        placeholder: 'Chọn...',
        allowClear: true
    });
    
    // Nếu có shift_name trong session, map ra shift_id kế tiếp nếu phù hợp
    (function preselectNextShift(){
        var metaEl = document.getElementById('prefillShiftMeta');
        var prefillShiftName = metaEl ? metaEl.getAttribute('data-shift') : '';
        if (!prefillShiftName) return;
        // Tìm option khớp tên ca, sau đó chọn option kế tiếp nếu tồn tại
        var select = document.getElementById('school_shift_id');
        if (!select) return;
        var idx = -1;
        for (var i=0;i<select.options.length;i++){
            var opt = select.options[i];
            if (opt.text && opt.text.indexOf(prefillShiftName) !== -1){ idx = i; break; }
        }
        if (idx !== -1 && idx+1 < select.options.length){
            select.selectedIndex = idx+1;
            $(select).trigger('change');
        }
    })();
    
    // Tự động cập nhật thứ trong tuần khi chọn ngày
    const scheduleDateInput = document.getElementById('schedule_date');
    const dayDisplayInput = document.getElementById('day_display');
    const dayOfWeekInput = document.getElementById('day_of_week');
    
    // Mảng tên thứ trong tuần
    const dayNames = [
        'Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 
        'Thứ 5', 'Thứ 6', 'Thứ 7'
    ];
    
    // Hàm cập nhật thứ trong tuần
    function updateDayOfWeek() {
        if (scheduleDateInput.value) {
            const selectedDate = new Date(scheduleDateInput.value);
            const dayIndex = selectedDate.getDay();
            const dayName = dayNames[dayIndex];
            
            dayDisplayInput.value = dayName;
            dayOfWeekInput.value = dayName;
        } else {
            dayDisplayInput.value = '';
            dayOfWeekInput.value = '';
        }
    }
    
    // Lắng nghe sự kiện thay đổi ngày
    scheduleDateInput.addEventListener('change', updateDayOfWeek);
    
    // Cập nhật ngay khi load trang nếu đã có giá trị
    if (scheduleDateInput.value) {
        updateDayOfWeek();
    }
    
    // Bulk modal removed

    // Debug: Kiểm tra giá trị teacher_id khi form submit
    setTimeout(function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const teacherId = document.getElementById('teacher_id').value;
                const scheduleDate = document.getElementById('schedule_date').value;
                console.log('Teacher ID being submitted:', teacherId);
                console.log('Schedule Date being submitted:', scheduleDate);
                
                // Kiểm tra các trường bắt buộc
                if (!teacherId) {
                    alert('Vui lòng chọn giảng viên!');
                    e.preventDefault();
                    return false;
                }
                
                if (!scheduleDate) {
                    alert('Vui lòng chọn ngày học!');
                    e.preventDefault();
                    return false;
                }
                
                // Cho phép thêm nhiều lịch cùng ngày - không có validation ngăn cản
                console.log('Form submitted successfully');
            });
        }
    }, 1000);

    // Revert: only Select2 init and day-of-week; remove dynamic disabling logic
    (function handleDisableEarlyShifts(){
        // no-op
    })();
});
</script>
