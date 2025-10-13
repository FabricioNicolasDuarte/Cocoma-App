<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCostDriver extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'driver_name',
        'driver_value'
    ];

    /**
     * Get the project that owns the cost driver.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
