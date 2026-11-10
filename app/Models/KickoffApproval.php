<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KickoffApproval extends Model
{
    protected $table = 'kickoff_approvals';
    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'mom_id',
        'participant_name',
        'participant_role',
        'user_id',
        'is_approved',
        'approved_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function mom(): BelongsTo
    {
        return $this->belongsTo(MomKickoff::class, 'mom_id', 'mom_id');
    }
}
