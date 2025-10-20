<?php

namespace App\Exports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AccountsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $query = Account::with('role');
        
        if ($this->keyword) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->keyword . '%')
                  ->orWhere('email', 'like', '%' . $this->keyword . '%');
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
            'Vai trò',
            'Ngày tạo',
            'Ngày cập nhật',
            'Trạng thái'
        ];
    }

    /**
     * @var $account
     * @return array
     */
    public function map($account): array
    {
        return [
            $account->id,
            $account->name,
            $account->email,
            $account->role ? $account->role->name : 'Không có vai trò',
            $account->created_at ? $account->created_at->format('d/m/Y H:i:s') : '',
            $account->updated_at ? $account->updated_at->format('d/m/Y H:i:s') : '',
            $account->deleted_at ? 'Đã xóa' : 'Hoạt động'
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
