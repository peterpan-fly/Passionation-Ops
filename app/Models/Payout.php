<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['creator_application_id', 'amount', 'currency', 'method', 'status', 'scheduled_for', 'paid_at', 'reference', 'notes'])]
class Payout extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'scheduled_for' => 'date',
            'paid_at' => 'date',
        ];
    }

    public function creatorApplication(): BelongsTo
    {
        return $this->belongsTo(CreatorApplication::class);
    }
}
