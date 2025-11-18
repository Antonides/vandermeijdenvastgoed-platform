<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tender extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'contractor_id',
        'component',
        'request_date',
        'planning_date',
        'received_date',
        'total_price',
        'note',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'request_date' => 'date',
        'planning_date' => 'date',
        'received_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * @var list<string>
     */
    protected $appends = [
        'price_per_square_meter',
    ];

    /**
     * Get the calculated price per square meter based on component type.
     */
    public function getPricePerSquareMeterAttribute(): ?float
    {
        if (!$this->total_price || !$this->project) {
            return null;
        }

        $area = match ($this->component) {
            'Nieuwbouw' => $this->project->oppervlakte_begane_grond,
            'Sloopwerkzaamheden' => $this->project->oppervlakte_perceel,
            default => null,
        };

        if (!$area || $area <= 0) {
            return null;
        }

        return round($this->total_price / $area, 2);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }
}
