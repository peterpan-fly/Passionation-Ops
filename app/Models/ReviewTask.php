<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['creator_application_id', 'title', 'owner', 'priority', 'status', 'due_at', 'notes'])]
class ReviewTask extends Model
{
    protected function casts(): array
    {
        return ['due_at' => 'date'];
    }

    public function creatorApplication(): BelongsTo
    {
        return $this->belongsTo(CreatorApplication::class);
    }
}
