<?php

namespace App\Exports;

use App\Models\Schedules;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SchedulesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Schedules::select(
            'schedules.*',
            'classes.name as class_name',
            'subjects.name as subject_name',
            'teachers.name as teacher_name',
            'school_shifts.name as shift_name',
            'school_shifts.start_time',
            'school_shifts.end_time',
            'classrooms.name as room_name'
        )
        ->join('classes', 'schedules.class_id', '=', 'classes.id')
        ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
        ->leftJoin('class_subjects', 'schedules.class_subject_id', '=', 'class_subjects.id')
        ->leftJoin('teachers', 'class_subjects.teacher_id', '=', 'teachers.id')
        ->leftJoin('school_shifts', 'schedules.school_shift_id', '=', 'school_shifts.id')
        ->leftJoin('classrooms', 'schedules.room_id', '=', 'classrooms.id');

        // Apply filters
        if (!empty($this->filters['keyword'])) {
            $keyword = strtolower($this->filters['keyword']);
            $query->where(function($q) use ($keyword) {
                $q->whereRaw("LOWER(classes.name) LIKE ?", ["%{$keyword}%"])
                  ->orWhereRaw("LOWER(subjects.name) LIKE ?", ["%{$keyword}%"])
                  ->orWhereRaw("LOWER(teachers.name) LIKE ?", ["%{$keyword}%"])
                  ->orWhereRaw("LOWER(classrooms.name) LIKE ?", ["%{$keyword}%"]);
            });
        }

        if (!empty($this->filters['class_id'])) {
            $query->where('schedules.class_id', $this->filters['class_id']);
        }

        if (!empty($this->filters['subject_id'])) {
            $query->where('schedules.subject_id', $this->filters['subject_id']);
        }

        if (!empty($this->filters['teacher_id'])) {
            $query->where('class_subjects.teacher_id', $this->filters['teacher_id']);
        }

        if (!empty($this->filters['school_shift_id'])) {
            $query->where('schedules.school_shift_id', $this->filters['school_shift_id']);
        }

        return $query->orderBy('schedules.schedule_date', 'ASC')
                    ->orderBy('schedules.school_shift_id', 'ASC')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Lớp học',
            'Môn học',
            'Giảng viên',
            'Ca học',
            'Thời gian bắt đầu',
            'Thời gian kết thúc',
            'Địa điểm học',
            'Ngày học',
            'Thứ trong tuần',
            'Ngày tạo',
        ];
    }

    public function map($schedule): array
    {
        return [
            $schedule->id,
            $schedule->class_name,
            $schedule->subject_name,
            $schedule->teacher_name ?? 'Chưa phân công',
            $schedule->shift_name ?? 'Chưa xác định',
            $schedule->start_time ?? 'Chưa xác định',
            $schedule->end_time ?? 'Chưa xác định',
            $schedule->room_name ?? 'Chưa xác định',
            $schedule->schedule_date ? \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') : 'Chưa xác định',
            $schedule->day_of_week ?? 'Chưa xác định',
            $schedule->created_at ? \Carbon\Carbon::parse($schedule->created_at)->format('d/m/Y H:i:s') : 'Chưa xác định',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
