<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectNoteReply extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_note_id',
        'user_id',
        'body',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(ProjectNote::class, 'project_note_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
