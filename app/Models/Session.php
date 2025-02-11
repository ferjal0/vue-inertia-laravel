<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'last_activity',
        'user_id',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    protected $appends = [
        'last_active_ago',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLastActiveAgoAttribute()
    {
        return $this->last_activity->diffForHumans();
    }
}
