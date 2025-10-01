<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkPreparation extends Model
{
    use HasFactory;

    public const STATUS_ACTION = 'actie';
    public const STATUS_IN_PROGRESS = 'lopend';
    public const STATUS_COMPLETED = 'afgerond';

    /**
     * @var list<string>
     */
    public const STATUSES = [
        self::STATUS_ACTION,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
    ];

    /**
     * @var list<string>
     */
    public const COMPONENTS = [
        'Archeologisch onderzoek',
        'Asbestinventarisatierapport',
        'BENG-Berekening',
        'Bodemonderzoek',
        'Brandrapport',
        'Constructieberekening',
        'Ecologisch onderzoek',
        'Funderingsadvies',
        'MPG-Berekening',
        'Sonderingen',
        'Stikstofberekening',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'component',
        'request_date',
        'planned_date',
        'received_date',
        'party',
        'status',
        'note',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'request_date' => 'date',
        'planned_date' => 'date',
        'received_date' => 'date',
    ];

    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'status' => self::STATUS_ACTION,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
