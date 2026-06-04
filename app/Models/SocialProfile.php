<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['creator_application_id', 'platform', 'handle', 'url', 'followers', 'engagement_rate', 'is_primary'])]
class SocialProfile extends Model
{
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'engagement_rate' => 'decimal:2',
        ];
    }

    public function creatorApplication(): BelongsTo
    {
        return $this->belongsTo(CreatorApplication::class);
    }
}
