<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'full_name', 'email', 'country_region', 'discovery_source', 'primary_platform',
    'follower_range', 'engagement_rate', 'content_niches', 'content_style',
    'collaboration_experience', 'past_brand_collaborations', 'best_branded_content_url',
    'portfolio_url', 'partnership_preferences', 'commission_payout_preference',
    'minimum_paid_post_rate', 'exclusive_partnership_preference', 'notes',
    'age_confirmed', 'status', 'fit_score', 'reviewed_at',
])]
class CreatorApplication extends Model
{
    protected function casts(): array
    {
        return [
            'content_niches' => 'array',
            'partnership_preferences' => 'array',
            'age_confirmed' => 'boolean',
            'reviewed_at' => 'datetime',
        ];
    }

    public function socialProfiles(): HasMany
    {
        return $this->hasMany(SocialProfile::class);
    }

    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    public function reviewTasks(): HasMany
    {
        return $this->hasMany(ReviewTask::class);
    }
}
