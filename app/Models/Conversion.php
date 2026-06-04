<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['affiliate_link_id', 'order_reference', 'order_value', 'commission_amount', 'status', 'converted_at'])]
class Conversion extends Model
{
    protected function casts(): array
    {
        return [
            'order_value' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'converted_at' => 'datetime',
        ];
    }

    public function affiliateLink(): BelongsTo
    {
        return $this->belongsTo(AffiliateLink::class);
    }
}
