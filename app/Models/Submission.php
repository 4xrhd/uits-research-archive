<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'archive_type',
        'author_role',
        'department',
        'batch',
        'academic_session',
        'research_domains',
        'authors',
        'external_links',
        'pdf_url',
        'drive_links',
        'abstract',
        'author_comments',
        'status',
        'admin_remarks',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'research_domains' => 'array',
        'authors' => 'array',
        'external_links' => 'array',
        'drive_links' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }
}
