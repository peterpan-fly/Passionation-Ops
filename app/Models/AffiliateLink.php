<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'creator_application_id', 'campaign_id', 'code', 'destination_url',
    'clicks', 'conversions_count', 'revenue', 'status',
])]
class AffiliateLink extends Model
{
    protected function casts(): array
    {
        return ['revenue' => 'decimal:2'];
    }

    public function creatorApplication(): BelongsTo
    {
        return $this->belongsTo(CreatorApplication::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(Conversion::class);
    }
}
