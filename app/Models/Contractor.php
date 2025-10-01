<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contractor extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'company_name',
        'contact_person',
        'phone',
        'email',
        'specialization',
        'street',
        'house_number',
        'postal_code',
        'city',
    ];

    protected static function booted(): void
    {
        static::creating(function (Contractor $contractor): void {
            if (blank($contractor->title)) {
                $contractor->title = $contractor->company_name;
            }
        });

        static::updating(function (Contractor $contractor): void {
            if (blank($contractor->title)) {
                $contractor->title = $contractor->company_name;
            }
        });
    }

    public function tenders(): HasMany
    {
        return $this->hasMany(Tender::class);
    }
}
