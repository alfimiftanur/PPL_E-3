<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaciTemplate extends Model
{
    protected $table = 'raci_templates';
    protected $primaryKey = 'raci_id';

    protected $fillable = [
        'process_no',
        'process_name',
        'role_code',
        'raci_value',
    ];

    protected $casts = [
        'process_no' => 'integer',
    ];
}
