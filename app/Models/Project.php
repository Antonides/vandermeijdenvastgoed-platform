<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'project_status',
        'city',
        'street',
        'house_number',
        'permit',
        'build_status',
        'start_build_date',
        'completion_date',
        'demolition_contractor_id',
        'build_contractor_id',
    ];

    protected $casts = [
        'start_build_date' => 'date',
        'completion_date' => 'date',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(ProjectNote::class);
    }

    public function workPreparations(): HasMany
    {
        return $this->hasMany(WorkPreparation::class);
    }

    public function tenders(): HasMany
    {
        return $this->hasMany(Tender::class);
    }

    public function demolitionContractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class, 'demolition_contractor_id');
    }

    public function buildContractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class, 'build_contractor_id');
    }
}
