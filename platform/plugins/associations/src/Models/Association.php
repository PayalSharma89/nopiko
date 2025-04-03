<?php

namespace Botble\Associations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model {
    use HasFactory;

    protected $table = 'associations';
    protected $fillable = [
        'name', 
        'description', 
        'type', 
        'activity', 
        'location', 
        'address', 
        'association_details', 
        'image', 
        'background', 
        'email', 
        'phone', 
        'website', 
        'facebook', 
        'twitter', 
        'instagram', 
        'communication', 
        'commission', 
        'status',
        'approval_status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'commission' => 'float',
        'status' => 'boolean',
    ];

    /**
     * Get the causes assigned to the association.
     */
    // public function causes(): BelongsToMany
    // {
    //     return $this->belongsToMany(Cause::class, 'association_cause', 'association_id', 'cause_id')->withTimestamps();
    // }

    /**
     * Scope a query to only include active associations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the status as Active/Inactive.
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->status ? 'Active' : 'Inactive',
        );
    }
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }
}
