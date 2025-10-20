<?php

namespace App\Exports;

use App\Models\Schedules;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $shift;
    protected $startDate;
    protected $endDate;

    public function __construct(Request $request)
    {
        $this->search = $request->input('search');
        $this->shift = $request->input('shift');
        $this->startDate = $request->input('start_date');
        $this->endDate = $request->input('end_date');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $teachersQuery = Schedules::select('class_subjects.teacher_id', 'teachers.name', 'teachers.code')
            ->selectRaw('COUNT(schedules.id) as total_sessions')
            ->selectRaw('COUNT(schedules.school_shift_id) as total_shifts')
            ->join('class_subjects', 'schedules.class_subject_id', '=', 'class_subjects.id')
            ->join('teachers', 'class_subjects.teacher_id', '=', 'teachers.id');
    
        // Apply search filter if a search query is provided
        if ($this->search) {
            $teachersQuery->where(function ($query) {
                $query->where('teachers.name', 'like', '%' . $this->search . '%')
                      ->orWhere('teachers.code', 'like', '%' . $this->search . '%');
            });
        }
    
        // Apply date filters
        if ($this->startDate && $this->endDate) {
            $teachersQuery->whereBetween('class_subjects.start_date', [$this->startDate, $this->endDate])
                          ->whereBetween('class_subjects.end_date', [$this->startDate, $this->endDate]);
        }
    
        // Apply shift filter if provided
        if ($this->shift) {
            $teachersQuery->where('schedules.school_shift_id', $this->shift);
        }
    
        // Group by teacher ID and fetch data
        return $teachersQuery->groupBy('class_subjects.teacher_id', 'teachers.name', 'teachers.code')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Giảng Viên',
            'Tên Giảng Viên',
            'Mã Giảng Viên',
            'Số Buổi Dạy',
            'Số Ca Dạy',
            'Số Giờ',
            'Lương Giờ',
            'Tổng Lương',
            'Chi Tiết Lương'
        ];
    }

    /**
     * @var $teacher
     * @return array
     */
    public function map($teacher): array
    {
        $hoursPerShift = 2;
        $hourlyRate = 200000;
        $basicSalary = 5600000;

        $totalHours = $teacher->total_shifts * $hoursPerShift;
        $hourlySalary = $totalHours * $hourlyRate;
        $totalSalary = $hourlySalary + $basicSalary;

        $salaryDetail = number_format($totalSalary, 0, ',', '.') . ' (' . convertNumberToWords($totalSalary) . ')';

        return [
            $teacher->teacher_id,
            $teacher->name,
            $teacher->code,
            $teacher->total_sessions,
            $teacher->total_shifts,
            $totalHours,
            number_format($hourlySalary, 0, ',', '.'),
            number_format($totalSalary, 0, ',', '.'),
            $salaryDetail,
        ];
    }
}
function convertNumberToWords($number)
{
    $hyphen = '-';
    $conjunction = ' và ';
    $separator = ', ';
    $negative = 'âm ';
    $decimal = ' phẩy ';
    $dictionary = [
        0 => 'không',
        1 => 'một',
        2 => 'hai',
        3 => 'ba',
        4 => 'bốn',
        5 => 'năm',
        6 => 'sáu',
        7 => 'bảy',
        8 => 'tám',
        9 => 'chín',
        10 => 'mười',
        11 => 'mười một',
        12 => 'mười hai',
        13 => 'mười ba',
        14 => 'mười bốn',
        15 => 'mười lăm',
        16 => 'mười sáu',
        17 => 'mười bảy',
        18 => 'mười tám',
        19 => 'mười chín',
        20 => 'hai mươi',
        30 => 'ba mươi',
        40 => 'bốn mươi',
        50 => 'năm mươi',
        60 => 'sáu mươi',
        70 => 'bảy mươi',
        80 => 'tám mươi',
        90 => 'chín mươi',
        100 => 'trăm',
        1000 => 'nghìn',
        1000000 => 'triệu',
        1000000000 => 'tỷ'
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error('convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string)$fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

