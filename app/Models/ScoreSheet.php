<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScoreSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'status',
        'uploaded_by',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the class that owns the score sheet.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the user who uploaded the score sheet.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope a query to only include public score sheets.
     */
    public function scopePublic($query)
    {
        return $query->where('status', 'public');
    }

    /**
     * Scope a query to only include hidden score sheets.
     */
    public function scopeHidden($query)
    {
        return $query->where('status', 'hidden');
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
     * Get file icon class based on file type.
     */
    public function getFileIconClassAttribute()
    {
        switch ($this->file_type) {
            case 'pdf':
                return 'fas fa-file-pdf text-danger';
            case 'xlsx':
            case 'xls':
                return 'fas fa-file-excel text-success';
            default:
                return 'fas fa-file text-secondary';
        }
    }
}
