<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_name',
        'kloc',
        'salary',
        'mode',
        'cocomo_model',
        'cost_drivers',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost_drivers' => 'array',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor to get the displayable name for the project mode.
     */
    protected function modeForDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->mode) {
                'organic' => 'Orgánico',
                'semidetached' => 'Semi-acoplado',
                'embedded' => 'Empotrado',
                default => ucfirst($this->mode),
            },
        );
    }
}

