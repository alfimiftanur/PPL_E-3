<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaselineMatrixRow extends Model
{
    protected $table = 'baseline_matrix_rows';
    protected $primaryKey = 'row_id';

    protected $fillable = [
        'baseline_id',
        'baseline_item_id',
        'matrix_type',
        'module',
        'description',
        'start_date',
        'end_date',
        'pic_role',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function baseline(): BelongsTo
    {
        return $this->belongsTo(Baseline::class, 'baseline_id', 'baseline_id');
    }
}
