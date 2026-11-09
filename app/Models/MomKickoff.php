<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MomKickoff extends Model
{
    protected $table = 'mom_kickoffs';
    protected $primaryKey = 'mom_id';

    protected $fillable = [
        'kickoff_id',
        'mom_attachment',
        'status',
        'completed_at',
        'recorded_by',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function kickoff(): BelongsTo
    {
        return $this->belongsTo(Kickoff::class, 'kickoff_id', 'kickoff_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(KickoffApproval::class, 'mom_id', 'mom_id');
    }
}
