<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CreateTestExcelFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo file Excel mẫu để test hệ thống quản lý bảng điểm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Đang tạo file Excel mẫu...');
        
        // Tạo thư mục nếu chưa có
        if (!file_exists(public_path('test_excel'))) {
            mkdir(public_path('test_excel'), 0755, true);
        }
        
        // Tạo file Bảng điểm chính
        $this->createMainScoreFile();
        
        // Tạo file Phụ lục 1
        $this->createAppendix1File();
        
        // Tạo file Phụ lục 2
        $this->createAppendix2File();
        
        $this->info('Đã tạo thành công 3 file Excel mẫu trong thư mục public/test_excel/');
    }
    
    private function createMainScoreFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Tiêu đề
        $sheet->setCellValue('A1', 'BẢNG ĐIỂM CHÍNH');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Thông tin lớp
        $sheet->setCellValue('A3', 'Lớp: WD18301');
        $sheet->setCellValue('A4', 'Môn: Lập trình PHP');
        $sheet->setCellValue('A5', 'Giáo viên: Nguyễn Văn A');
        $sheet->setCellValue('A6', 'Học kỳ: Học kỳ 1 - Năm học 2024-2025');
        
        // Header bảng điểm
        $headers = ['STT', 'MSSV', 'Họ và tên', 'L1', 'L2', 'L3', 'L4', 'ASM1', 'ASM2', 'Final', 'GPA', 'Kết quả'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '8', $header);
            $col++;
        }
        
        // Dữ liệu mẫu
        $students = [
            ['1', 'SV001', 'Nguyễn Văn An', '8.5', '9.0', '8.0', '8.5', '9.0', '8.5', '8.0', '8.4', 'PASSED'],
            ['2', 'SV002', 'Trần Thị Bình', '7.5', '8.0', '7.5', '8.0', '8.5', '7.5', '7.0', '7.7', 'PASSED'],
            ['3', 'SV003', 'Lê Văn Cường', '6.5', '7.0', '6.5', '7.0', '7.5', '6.5', '6.0', '6.7', 'PASSED'],
            ['4', 'SV004', 'Phạm Thị Dung', '5.5', '6.0', '5.5', '6.0', '6.5', '5.5', '5.0', '5.7', 'PASSED'],
            ['5', 'SV005', 'Hoàng Văn Em', '4.5', '5.0', '4.5', '5.0', '5.5', '4.5', '4.0', '4.7', 'FAILED'],
        ];
        
        $row = 9;
        foreach ($students as $student) {
            $col = 'A';
            foreach ($student as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Style cho header
        $sheet->getStyle('A8:L8')->getFont()->setBold(true);
        $sheet->getStyle('A8:L8')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E0E0E0');
        
        // Auto size columns
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('test_excel/bang_diem_chinh.xlsx'));
        
        $this->info('✓ Đã tạo file: bang_diem_chinh.xlsx');
    }
    
    private function createAppendix1File()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Tiêu đề
        $sheet->setCellValue('A1', 'PHỤ LỤC 1 - CHI TIẾT ĐIỂM LAB');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Thông tin
        $sheet->setCellValue('A3', 'Lớp: WD18301');
        $sheet->setCellValue('A4', 'Môn: Lập trình PHP');
        $sheet->setCellValue('A5', 'Giáo viên: Nguyễn Văn A');
        
        // Header
        $headers = ['STT', 'MSSV', 'Họ và tên', 'Lab 1', 'Lab 2', 'Lab 3', 'Lab 4', 'Tổng Lab', 'Ghi chú'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '7', $header);
            $col++;
        }
        
        // Dữ liệu mẫu
        $students = [
            ['1', 'SV001', 'Nguyễn Văn An', '8.5', '9.0', '8.0', '8.5', '8.5', 'Tốt'],
            ['2', 'SV002', 'Trần Thị Bình', '7.5', '8.0', '7.5', '8.0', '7.8', 'Khá'],
            ['3', 'SV003', 'Lê Văn Cường', '6.5', '7.0', '6.5', '7.0', '6.8', 'Trung bình'],
            ['4', 'SV004', 'Phạm Thị Dung', '5.5', '6.0', '5.5', '6.0', '5.8', 'Yếu'],
            ['5', 'SV005', 'Hoàng Văn Em', '4.5', '5.0', '4.5', '5.0', '4.8', 'Kém'],
        ];
        
        $row = 8;
        foreach ($students as $student) {
            $col = 'A';
            foreach ($student as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Style
        $sheet->getStyle('A7:I7')->getFont()->setBold(true);
        $sheet->getStyle('A7:I7')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E0E0E0');
        
        // Auto size columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('test_excel/phu_luc_1.xlsx'));
        
        $this->info('✓ Đã tạo file: phu_luc_1.xlsx');
    }
    
    private function createAppendix2File()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Tiêu đề
        $sheet->setCellValue('A1', 'PHỤ LỤC 2 - CHI TIẾT ĐIỂM ASSIGNMENT VÀ FINAL');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Thông tin
        $sheet->setCellValue('A3', 'Lớp: WD18301');
        $sheet->setCellValue('A4', 'Môn: Lập trình PHP');
        $sheet->setCellValue('A5', 'Giáo viên: Nguyễn Văn A');
        
        // Header
        $headers = ['STT', 'MSSV', 'Họ và tên', 'ASM1', 'ASM2', 'Final', 'Tổng ASM', 'Ghi chú'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '7', $header);
            $col++;
        }
        
        // Dữ liệu mẫu
        $students = [
            ['1', 'SV001', 'Nguyễn Văn An', '9.0', '8.5', '8.0', '8.5', 'Xuất sắc'],
            ['2', 'SV002', 'Trần Thị Bình', '8.5', '7.5', '7.0', '7.7', 'Tốt'],
            ['3', 'SV003', 'Lê Văn Cường', '7.5', '6.5', '6.0', '6.7', 'Trung bình'],
            ['4', 'SV004', 'Phạm Thị Dung', '6.5', '5.5', '5.0', '5.7', 'Yếu'],
            ['5', 'SV005', 'Hoàng Văn Em', '5.5', '4.5', '4.0', '4.7', 'Kém'],
        ];
        
        $row = 8;
        foreach ($students as $student) {
            $col = 'A';
            foreach ($student as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Style
        $sheet->getStyle('A7:H7')->getFont()->setBold(true);
        $sheet->getStyle('A7:H7')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E0E0E0');
        
        // Auto size columns
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('test_excel/phu_luc_2.xlsx'));
        
        $this->info('✓ Đã tạo file: phu_luc_2.xlsx');
    }
}
