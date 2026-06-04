<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'brand_id', 'name', 'campaign_type', 'status', 'target_niches', 'target_countries',
    'commission_rate', 'flat_fee_budget', 'starts_at', 'ends_at', 'brief',
])]
class Campaign extends Model
{
    protected function casts(): array
    {
        return [
            'target_niches' => 'array',
            'target_countries' => 'array',
            'commission_rate' => 'decimal:2',
            'flat_fee_budget' => 'decimal:2',
            'starts_at' => 'date',
            'ends_at' => 'date',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }
}
