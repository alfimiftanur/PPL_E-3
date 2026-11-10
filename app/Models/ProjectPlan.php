<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPlan extends Model
{
    protected $table = 'project_plans';
    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'project_id',
        'planned_date',
        'due_date_h1',
        'baseline_id',
        'scope_section',
        'deliverable_section',
        'timeline_section',
        'roadmap_section',
        'target_progress',
        'updated_by',
    ];

    protected $casts = [
        'planned_date' => 'date:Y-m-d',
        'due_date_h1' => 'date:Y-m-d',
        'target_progress' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function baseline(): BelongsTo
    {
        return $this->belongsTo(Baseline::class, 'baseline_id', 'baseline_id');
    }
}
