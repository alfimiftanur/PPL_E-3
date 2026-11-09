<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'project_id',
        'canonical_code',
        'project_name',
        'client_name',
        'client_division',
        'intake_status',
        'handover_date',
        'pm_name',
        'pm_employee_id',
        'pm_user_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'handover_date' => 'date:Y-m-d',
    ];

    public function initialAnalysis(): HasOne
    {
        return $this->hasOne(InitialAnalysis::class, 'project_id', 'project_id');
    }

    public function baselines(): HasMany
    {
        return $this->hasMany(Baseline::class, 'project_id', 'project_id');
    }

    public function projectPlan(): HasOne
    {
        return $this->hasOne(ProjectPlan::class, 'project_id', 'project_id');
    }

    public function kickoffs(): HasMany
    {
        return $this->hasMany(Kickoff::class, 'project_id', 'project_id');
    }

    public function resourceMatrices(): HasMany
    {
        return $this->hasMany(ResourceMatrix::class, 'project_id', 'project_id');
    }
}
