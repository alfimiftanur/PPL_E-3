<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kickoff extends Model
{
    protected $table = 'kickoffs';
    protected $primaryKey = 'kickoff_id';

    protected $fillable = [
        'project_id',
        'plan_id',
        'agenda',
        'material',
        'created_by',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function projectPlan(): BelongsTo
    {
        return $this->belongsTo(ProjectPlan::class, 'plan_id', 'plan_id');
    }

    public function mom(): HasOne
    {
        return $this->hasOne(MomKickoff::class, 'kickoff_id', 'kickoff_id');
    }
}
