<div class="card custom-border" style="border: 1px solid #ccc">
    <div class="card-body">
        <div class="row">
            <!-- Chọn lớp -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="class_id">Lớp <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="class_id" name="class_id" required>
                        <option value="">-- Chọn lớp --</option>
                        @if(isset($classes))
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" 
                                        {{ (isset($schedule) && $schedule->class_id == $class->id) || old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('class_id')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Chọn môn học -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="subject_id">Môn học <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="subject_id" name="subject_id" required>
                        <option value="">-- Chọn môn học --</option>
                        @if(isset($subjects))
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" 
                                        {{ (isset($schedule) && $schedule->subject_id == $subject->id) || old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('subject_id')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Chọn giảng viên -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="teacher_id">Giảng viên <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="teacher_id" name="teacher_id" required>
                        <option value="">-- Chọn giảng viên --</option>
                        @if(isset($teachers))
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" 
                                        {{ (isset($schedule) && $schedule->teacher_id == $teacher->id) || old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} - {{ $teacher->code ?? 'N/A' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('teacher_id')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Chọn ca học -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="school_shift_id">Ca học <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="school_shift_id" name="school_shift_id" required>
                        <option value="">-- Chọn ca học --</option>
                        @if(isset($schoolShifts))
                            @foreach($schoolShifts as $shift)
                                <option value="{{ $shift->id }}" 
                                        {{ (isset($schedule) && $schedule->school_shift_id == $shift->id) || old('school_shift_id') == $shift->id ? 'selected' : '' }}>
                                    {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('school_shift_id')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Chọn địa điểm học -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_id">Địa điểm học <span class="text-danger">*</span></label>
                    <select class="form-control setupSelect2" id="room_id" name="room_id" required>
                        <option value="">-- Chọn địa điểm học --</option>
                        @if(isset($classrooms))
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" 
                                        {{ (isset($schedule) && $schedule->room_id == $classroom->id) || old('room_id') == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('room_id')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Chọn ngày học -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="schedule_date">Ngày học <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control" 
                           id="schedule_date" 
                           name="schedule_date" 
                           value="{{ isset($schedule) ? $schedule->schedule_date : old('schedule_date') }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                    @error('schedule_date')
                        <p class="message_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
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
                           value="{{ isset($schedule) ? $schedule->day_of_week : old('day_of_week') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
