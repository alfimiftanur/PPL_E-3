<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceMatrix extends Model
{
    protected $table = 'resource_matrices';
    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'project_id',
        'role',
        'person_name',
        'is_dummy',
        'employee_id',
        'module',
        'allocation_percent',
        'start_date',
        'end_date',
        'updated_by',
    ];

    protected $casts = [
        'is_dummy' => 'boolean',
        'allocation_percent' => 'integer',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
