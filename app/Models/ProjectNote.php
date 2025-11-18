<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectNote extends Model
{
    use HasFactory;

    public const STATUS_ACTION = 'actie';

    public const STATUS_IN_PROGRESS = 'lopend';

    public const STATUS_COMPLETED = 'afgerond';

    public const STATUS_INFO = 'informatief';

    /**
     * @var list<string>
     */
    public const STATUSES = [
        self::STATUS_ACTION,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
        self::STATUS_INFO,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'body',
        'status',
        'reminder_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'reminder_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ProjectNoteReply::class);
    }
}
