<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reclamation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'user_id',
        'description',
        'status',
        'image_remarque',
        'created_by',
        'Priorite',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the reclamation.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the user assigned to the reclamation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created the reclamation.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the reclamation reference number.
     */
    public function getReferenceAttribute(): string
    {
        return '#REC-' . date('Y', strtotime($this->created_at)) . '-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the priority badge class.
     */
    public function getPriorityClassAttribute(): string
    {
        return match ($this->Priorite) {
            'Haute' => 'bg-red-100 text-red-800',
            'Moyenne' => 'bg-yellow-100 text-yellow-800',
            'Basse' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status badge class.
     */
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'nouvelle' => 'bg-blue-100 text-blue-800',
            'en_cours' => 'bg-yellow-100 text-yellow-800',
            'résolue' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'nouvelle' => 'Nouvelle',
            'en_cours' => 'En cours',
            'résolue' => 'Résolue',
            default => ucfirst($this->status),
        };
    }

    /**
     * Scope a query to only include reclamations of a given status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include reclamations of a given priority.
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('Priorite', $priority);
    }

    /**
     * Scope a query to only include recent reclamations.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to search reclamations.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
              ->orWhereHas('client', function ($clientQuery) use ($search) {
                  $clientQuery->where('nom', 'like', "%{$search}%")
                             ->orWhere('prenom', 'like', "%{$search}%");
              });
        });
    }
}
