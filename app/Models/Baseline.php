<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Baseline extends Model
{
    protected $table = 'baselines';
    protected $primaryKey = 'baseline_id';

    protected $fillable = [
        'project_id',
        'analysis_id',
        'version',
        'baseline_date',
        'status',
        'approved_by',
        'approved_at',
        'simulator_mode',
        'is_complete',
        'created_by',
    ];

    protected $casts = [
        'version' => 'integer',
        'simulator_mode' => 'integer',
        'is_complete' => 'boolean',
        'baseline_date' => 'date:Y-m-d',
        'approved_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function initialAnalysis(): BelongsTo
    {
        return $this->belongsTo(InitialAnalysis::class, 'analysis_id', 'analysis_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BaselineItem::class, 'baseline_id', 'baseline_id');
    }

    public function matrixRows(): HasMany
    {
        return $this->hasMany(BaselineMatrixRow::class, 'baseline_id', 'baseline_id');
    }

    public function technicalPlans(): HasMany
    {
        return $this->hasMany(TechnicalPlan::class, 'baseline_id', 'baseline_id');
    }
}
