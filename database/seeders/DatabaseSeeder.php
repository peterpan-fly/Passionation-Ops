<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Conversion;
use App\Models\CreatorApplication;
use App\Models\Payout;
use App\Models\ReviewTask;
use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => env('ADMIN_EMAIL', 'admin@passionation.test'),
        ], [
            'name' => env('ADMIN_NAME', 'Passionation Admin'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'PassionationAdmin!2026')),
        ]);

        $maya = CreatorApplication::updateOrCreate(['email' => 'maya.creator@example.com'], [
            'full_name' => 'Maya Tan',
            'country_region' => 'Malaysia',
            'discovery_source' => 'Instagram / TikTok ad',
            'primary_platform' => 'TikTok',
            'follower_range' => '10,001 - 50,000',
            'engagement_rate' => '6% - 10%',
            'content_niches' => ['Beauty & Skincare', 'Travel & Lifestyle', 'Education & Self-improvement'],
            'content_style' => 'Short-form skincare and lifestyle videos for young professionals who want practical routines, honest product trials, and weekend travel ideas.',
            'collaboration_experience' => 'Yes, I have (paid collaborations)',
            'past_brand_collaborations' => 'GlowLab - TikTok - 2025; PureSkin - Instagram - 2024; TravelNest - TikTok - 2024',
            'best_branded_content_url' => 'https://tiktok.com/@maya.makes/video/1234567890',
            'portfolio_url' => 'https://mayamakes.example.com/media-kit',
            'partnership_preferences' => ['Affiliate commissions', 'Paid content creation', 'Long-term brand ambassador role'],
            'commission_payout_preference' => 'Bank transfer',
            'minimum_paid_post_rate' => 'RM 350 per TikTok video or RM 250 per Instagram reel',
            'exclusive_partnership_preference' => 'Yes, for the right fit',
            'notes' => 'Can create Bahasa Malaysia and English content with campaign reports.',
            'age_confirmed' => true,
            'status' => 'approved',
            'fit_score' => 88,
            'reviewed_at' => now()->subDays(2),
        ]);

        $amir = CreatorApplication::updateOrCreate(['email' => 'amir.creator@example.com'], [
            'full_name' => 'Amir Rahman',
            'country_region' => 'Malaysia',
            'discovery_source' => 'A friend or fellow creator',
            'primary_platform' => 'Instagram',
            'follower_range' => '5,001 - 10,000',
            'engagement_rate' => '3% - 6%',
            'content_niches' => ['Food & Beverage', 'Travel & Lifestyle'],
            'content_style' => 'Food discovery reels and cafe reviews for Klang Valley audiences.',
            'collaboration_experience' => 'Yes, but only gifted/unpaid',
            'partnership_preferences' => ['Gifted products', 'One-off campaign collaborations', 'Affiliate commissions'],
            'commission_payout_preference' => 'E-wallet',
            'minimum_paid_post_rate' => 'RM 180 per Instagram reel',
            'exclusive_partnership_preference' => 'Open to discussion',
            'age_confirmed' => true,
            'status' => 'reviewing',
            'fit_score' => 74,
        ]);

        $lina = CreatorApplication::updateOrCreate(['email' => 'lina.creator@example.com'], [
            'full_name' => 'Lina Suraya',
            'country_region' => 'Singapore',
            'discovery_source' => 'Google search',
            'primary_platform' => 'YouTube',
            'follower_range' => '50,001 - 100,000',
            'engagement_rate' => '3% - 6%',
            'content_niches' => ['Technology & Gadgets', 'Education & Self-improvement'],
            'content_style' => 'Long-form product explainers and buyer guides for practical tech upgrades.',
            'collaboration_experience' => 'Yes, I have (paid collaborations)',
            'partnership_preferences' => ['Paid content creation', 'Affiliate commissions'],
            'commission_payout_preference' => 'PayPal',
            'minimum_paid_post_rate' => 'SGD 900 per YouTube integration',
            'exclusive_partnership_preference' => 'No, I prefer to stay non-exclusive',
            'age_confirmed' => true,
            'status' => 'waitlisted',
            'fit_score' => 81,
        ]);

        SocialProfile::updateOrCreate(['creator_application_id' => $maya->id, 'platform' => 'TikTok'], ['handle' => '@maya.makes', 'url' => 'https://tiktok.com/@maya.makes', 'followers' => 32400, 'engagement_rate' => 8.4, 'is_primary' => true]);
        SocialProfile::updateOrCreate(['creator_application_id' => $maya->id, 'platform' => 'Instagram'], ['handle' => '@maya.makes', 'url' => 'https://instagram.com/maya.makes', 'followers' => 15400, 'engagement_rate' => 6.2, 'is_primary' => false]);
        SocialProfile::updateOrCreate(['creator_application_id' => $amir->id, 'platform' => 'Instagram'], ['handle' => '@makanwithamir', 'url' => 'https://instagram.com/makanwithamir', 'followers' => 8700, 'engagement_rate' => 4.8, 'is_primary' => true]);
        SocialProfile::updateOrCreate(['creator_application_id' => $lina->id, 'platform' => 'YouTube'], ['handle' => '@linareviews', 'url' => 'https://youtube.com/@linareviews', 'followers' => 68400, 'engagement_rate' => 3.9, 'is_primary' => true]);

        $glowlab = Brand::updateOrCreate(['name' => 'GlowLab'], ['industry' => 'Beauty & Skincare', 'country_region' => 'Malaysia', 'website' => 'https://glowlab.example.com', 'contact_name' => 'Nadia Lim', 'contact_email' => 'nadia@glowlab.example.com', 'status' => 'active']);
        $travelnest = Brand::updateOrCreate(['name' => 'TravelNest'], ['industry' => 'Travel & Lifestyle', 'country_region' => 'Malaysia', 'website' => 'https://travelnest.example.com', 'contact_name' => 'Jason Wong', 'contact_email' => 'jason@travelnest.example.com', 'status' => 'active']);

        $serumCampaign = Campaign::updateOrCreate(['name' => 'Hydra Serum Nano Launch'], [
            'brand_id' => $glowlab->id,
            'campaign_type' => 'affiliate',
            'status' => 'active',
            'target_niches' => ['Beauty & Skincare'],
            'target_countries' => ['Malaysia', 'Singapore'],
            'commission_rate' => 12,
            'flat_fee_budget' => 4500,
            'starts_at' => now()->subDays(7),
            'ends_at' => now()->addMonth(),
            'brief' => 'Recruit nano creators for honest routine-based content and track purchases through creator codes.',
        ]);

        $hotelCampaign = Campaign::updateOrCreate(['name' => 'Weekend Escape Creator Push'], [
            'brand_id' => $travelnest->id,
            'campaign_type' => 'paid_content',
            'status' => 'recruiting',
            'target_niches' => ['Travel & Lifestyle', 'Food & Beverage'],
            'target_countries' => ['Malaysia'],
            'commission_rate' => 8,
            'flat_fee_budget' => 6200,
            'starts_at' => now()->addWeek(),
            'ends_at' => now()->addMonths(2),
            'brief' => 'Promote short-stay bookings through TikTok and Instagram creators.',
        ]);

        $mayaLink = AffiliateLink::updateOrCreate(['code' => 'MAYA12'], ['creator_application_id' => $maya->id, 'campaign_id' => $serumCampaign->id, 'destination_url' => 'https://glowlab.example.com/hydra-serum?ref=MAYA12', 'clicks' => 1184, 'conversions_count' => 42, 'revenue' => 7134, 'status' => 'active']);
        $amirLink = AffiliateLink::updateOrCreate(['code' => 'AMIR8'], ['creator_application_id' => $amir->id, 'campaign_id' => $hotelCampaign->id, 'destination_url' => 'https://travelnest.example.com/weekend?ref=AMIR8', 'clicks' => 426, 'conversions_count' => 8, 'revenue' => 2720, 'status' => 'active']);

        Conversion::updateOrCreate(['order_reference' => 'GL-10045'], ['affiliate_link_id' => $mayaLink->id, 'order_value' => 169.00, 'commission_amount' => 20.28, 'status' => 'approved', 'converted_at' => now()->subDays(3)]);
        Conversion::updateOrCreate(['order_reference' => 'GL-10078'], ['affiliate_link_id' => $mayaLink->id, 'order_value' => 238.00, 'commission_amount' => 28.56, 'status' => 'pending', 'converted_at' => now()->subDay()]);
        Conversion::updateOrCreate(['order_reference' => 'TN-8821'], ['affiliate_link_id' => $amirLink->id, 'order_value' => 340.00, 'commission_amount' => 27.20, 'status' => 'approved', 'converted_at' => now()->subDays(2)]);

        Payout::updateOrCreate(['creator_application_id' => $maya->id, 'reference' => 'seed-maya-first-cycle'], ['amount' => 312.40, 'currency' => 'MYR', 'method' => 'Bank transfer', 'status' => 'scheduled', 'scheduled_for' => now()->addDays(10), 'paid_at' => null, 'notes' => 'First affiliate payout cycle.']);
        Payout::updateOrCreate(['creator_application_id' => $amir->id, 'reference' => 'seed-amir-first-cycle'], ['amount' => 78.20, 'currency' => 'MYR', 'method' => 'E-wallet', 'status' => 'pending', 'scheduled_for' => now()->addDays(14), 'paid_at' => null, 'notes' => null]);

        ReviewTask::updateOrCreate(['creator_application_id' => $amir->id, 'title' => 'Review Amir food reel audience fit'], ['owner' => 'Creator Ops', 'priority' => 'medium', 'status' => 'open', 'due_at' => now()->addDays(2), 'notes' => 'Check cafe category exclusivity.']);
        ReviewTask::updateOrCreate(['creator_application_id' => $lina->id, 'title' => 'Confirm Singapore payout requirements'], ['owner' => 'Finance', 'priority' => 'high', 'status' => 'in_progress', 'due_at' => now()->addDay(), 'notes' => 'Needs PayPal workflow confirmation.']);
    }
}
