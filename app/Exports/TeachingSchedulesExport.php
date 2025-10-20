<?php

namespace App\Exports;

use App\Models\Schedules;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeachingSchedulesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $keyword;

    public function __construct($keyword = null)
    {
        $this->keyword = $keyword;
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
            'school_shifts.end_time'
        )
            ->join('classes', 'schedules.class_id', '=', 'classes.id')
            ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->leftJoin('class_subjects', 'schedules.class_subject_id', '=', 'class_subjects.id')
            ->leftJoin('teachers', 'class_subjects.teacher_id', '=', 'teachers.id')
            ->leftJoin('school_shifts', 'schedules.school_shift_id', '=', 'school_shifts.id');

        if ($this->keyword) {
            $query->where(function ($q) {
                $q->whereRaw("LOWER(classes.name) LIKE ?", ["%" . strtolower($this->keyword) . "%"])
                  ->orWhereRaw("LOWER(subjects.name) LIKE ?", ["%" . strtolower($this->keyword) . "%"])
                  ->orWhereRaw("LOWER(teachers.name) LIKE ?", ["%" . strtolower($this->keyword) . "%"]);
            });
        }

        return $query->orderBy('schedules.created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Môn học',
            'Lớp học',
            'Giảng viên',
            'Ca dạy',
            'Thời gian',
            'Ngày học',
            'Thứ trong tuần',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }

    public function map($schedule): array
    {
        return [
            $schedule->id,
            $schedule->subject_name,
            $schedule->class_name,
            $schedule->teacher_name ?? 'Chưa xác định',
            $schedule->shift_name ?? 'Chưa xác định',
            $schedule->start_time && $schedule->end_time ? $schedule->start_time . ' - ' . $schedule->end_time : 'Chưa xác định',
            $schedule->schedule_date ? \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') : 'Chưa xác định',
            $schedule->day_of_week,
            $schedule->created_at ? $schedule->created_at->format('d/m/Y H:i:s') : '',
            $schedule->updated_at ? $schedule->updated_at->format('d/m/Y H:i:s') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
