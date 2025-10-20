<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlHdtl1File extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'file_type',
        'file_name',
        'file_path',
        'file_size',
        'file_extension',
        'status',
        'uploaded_by',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the class that owns the file.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope a query to only include public files.
     */
    public function scopePublic($query)
    {
        return $query->where('status', 'public');
    }

    /**
     * Scope a query to only include hidden files.
     */
    public function scopeHidden($query)
    {
        return $query->where('status', 'hidden');
    }

    /**
     * Scope a query by file type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = (int) $this->file_size;
        if ($bytes === 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Get file icon class based on file extension.
     */
    public function getFileIconClassAttribute()
    {
        switch ($this->file_extension) {
            case 'pdf':
                return 'fas fa-file-pdf text-danger';
            case 'xlsx':
            case 'xls':
                return 'fas fa-file-excel text-success';
            default:
                return 'fas fa-file text-secondary';
        }
    }

    /**
     * Get file type display name.
     */
    public function getFileTypeDisplayAttribute()
    {
        $types = [
            'kqhttx' => 'KQHTTX',
            'kqrl' => 'KQRL',
            'ngay_cong' => 'Ngày công học tập',
            'dieu_chinh' => 'Điều chỉnh',
            'ren_luyen_kha' => 'Học viên rèn luyện khá',
            'hoc_gioi' => 'Danh sách học viên học giỏi'
        ];

        return $types[$this->file_type] ?? $this->file_type;
    }
}
