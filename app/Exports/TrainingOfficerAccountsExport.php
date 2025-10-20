<?php

namespace App\Exports;

use App\Models\TrainingOfficer\TrainingOfficerAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrainingOfficerAccountsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $keyword;

    public function __construct($keyword = null)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = TrainingOfficerAccount::withTrashed();
        
        if ($this->keyword) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->keyword . '%')
                  ->orWhere('email', 'like', '%' . $this->keyword . '%')
                  ->orWhere('phone', 'like', '%' . $this->keyword . '%');
            });
        }
        
        return $query->orderBy('created_at', 'DESC')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Tên',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Quê quán',
            'Ngày tạo',
            'Ngày cập nhật',
            'Trạng thái'
        ];
    }

    /**
     * @var $trainingOfficer
     * @return array
     */
    public function map($trainingOfficer): array
    {
        return [
            $trainingOfficer->id,
            $trainingOfficer->name,
            $trainingOfficer->email,
            $trainingOfficer->phone,
            $trainingOfficer->address,
            $trainingOfficer->hometown,
            $trainingOfficer->created_at ? $trainingOfficer->created_at->format('d/m/Y H:i:s') : '',
            $trainingOfficer->updated_at ? $trainingOfficer->updated_at->format('d/m/Y H:i:s') : '',
            $trainingOfficer->deleted_at ? 'Đã xóa' : 'Hoạt động'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
