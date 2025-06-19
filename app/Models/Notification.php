<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'is_read',
        'created_by',
        'data',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Mark notification as read
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    // Get time ago
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    // Get icon based on type
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            'client' => 'fas fa-user-plus',
            'document' => 'fas fa-file-signature',
            'event' => 'fas fa-calendar-check',
            'reminder' => 'fas fa-clock',
            default => 'fas fa-info-circle',
        };
    }

    // Get color class based on type
    public function getColorClassAttribute(): string
    {
        return match($this->type) {
            'success' => 'text-green-500',
            'warning' => 'text-yellow-500',
            'error' => 'text-red-500',
            'client' => 'text-blue-500',
            'document' => 'text-green-500',
            'event' => 'text-yellow-500',
            'reminder' => 'text-purple-500',
            default => 'text-blue-500',
        };
    }

    // Get background class for unread notifications
    public function getBgClassAttribute(): string
    {
        if (!$this->is_read) {
            return match($this->type) {
                'success' => 'bg-green-50 border-green-100',
                'warning' => 'bg-yellow-50 border-yellow-100',
                'error' => 'bg-red-50 border-red-100',
                'client' => 'bg-blue-50 border-blue-100',
                'document' => 'bg-green-50 border-green-100',
                'event' => 'bg-yellow-50 border-yellow-100',
                'reminder' => 'bg-purple-50 border-purple-100',
                default => 'bg-blue-50 border-blue-100',
            };
        }

        return 'bg-white border-gray-200';
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}


