<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_legal_document_id',
        'notification_type',
        'title',
        'message',
        'is_read',
        'notification_date',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'notification_date' => 'date',
    ];

    /**
     * Get the project legal document that owns the notification.
     */
    public function projectLegalDocument()
    {
        return $this->belongsTo(ProjectLegalDocument::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        $this->is_read = true;
        return $this->save();
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
