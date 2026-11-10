<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaselineItem extends Model
{
    protected $table = 'baseline_items';

    protected $primaryKey = 'baseline_item_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'baseline_item_id',
        'baseline_id',
        'project_id',
        'name',
        'type',
    ];

    public function baseline(): BelongsTo
    {
        return $this->belongsTo(Baseline::class, 'baseline_id', 'baseline_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
