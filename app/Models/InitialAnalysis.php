<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InitialAnalysis extends Model
{
    protected $table = 'initial_analyses';
    protected $primaryKey = 'analysis_id';

    protected $fillable = [
        'project_id',
        'project_need',
        'project_condition',
        'status',
        'is_saved',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_saved' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
