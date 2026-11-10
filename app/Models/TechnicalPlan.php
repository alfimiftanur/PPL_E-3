<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicalPlan extends Model
{
    protected $table = 'technical_plans';
    protected $primaryKey = 'estimate_id';

    protected $fillable = [
        'baseline_id',
        'row_id',
        'estimate_hours',
        'estimated_by',
    ];

    protected $casts = [
        'estimate_hours' => 'decimal:2',
    ];

    public function baseline(): BelongsTo
    {
        return $this->belongsTo(Baseline::class, 'baseline_id', 'baseline_id');
    }

    public function matrixRow(): BelongsTo
    {
        return $this->belongsTo(BaselineMatrixRow::class, 'row_id', 'row_id');
    }
}
