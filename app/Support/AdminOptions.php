<?php

namespace App\Support;

class AdminOptions
{
    public static function statuses(): array
    {
        return ['new' => 'New', 'reviewing' => 'Reviewing', 'approved' => 'Approved', 'rejected' => 'Rejected', 'waitlisted' => 'Waitlisted'];
    }

    public static function platforms(): array
    {
        return ['Instagram' => 'Instagram', 'TikTok' => 'TikTok', 'YouTube' => 'YouTube', 'Facebook' => 'Facebook', 'Blog / Website' => 'Blog / Website'];
    }

    public static function countries(): array
    {
        return ['Malaysia' => 'Malaysia', 'Singapore' => 'Singapore', 'Indonesia' => 'Indonesia', 'Thailand' => 'Thailand', 'Philippine' => 'Philippine', 'Vietnam' => 'Vietnam'];
    }

    public static function sources(): array
    {
        return ['Instagram / TikTok ad' => 'Instagram / TikTok ad', 'A friend or fellow creator' => 'A friend or fellow creator', 'Google search' => 'Google search', 'An existing Passionation creator' => 'An existing Passionation creator', 'Other' => 'Other'];
    }

    public static function followerRanges(): array
    {
        return ['1,000 - 5,000' => '1,000 - 5,000', '5,001 - 10,000' => '5,001 - 10,000', '10,001 - 50,000' => '10,001 - 50,000', '50,001 - 100,000' => '50,001 - 100,000', '100,001+' => '100,001+'];
    }

    public static function engagementRates(): array
    {
        return ['Less than 1%' => 'Less than 1%', '1% - 3%' => '1% - 3%', '3% - 6%' => '3% - 6%', '6% - 10%' => '6% - 10%', 'More than 10%' => 'More than 10%', "I'm not sure" => "I'm not sure"];
    }

    public static function niches(): array
    {
        return ['Beauty & Skincare' => 'Beauty & Skincare', 'Fashion & Style' => 'Fashion & Style', 'Health & Wellness / Fitness' => 'Health & Wellness / Fitness', 'Food & Beverage' => 'Food & Beverage', 'Travel & Lifestyle' => 'Travel & Lifestyle', 'Home & Decor' => 'Home & Decor', 'Parenting & Family' => 'Parenting & Family', 'Technology & Gadgets' => 'Technology & Gadgets', 'Finance & Business' => 'Finance & Business', 'Education & Self-improvement' => 'Education & Self-improvement', 'Entertainment & Pop Culture' => 'Entertainment & Pop Culture'];
    }

    public static function collaborationLevels(): array
    {
        return ['Yes, I have (paid collaborations)' => 'Yes, I have (paid collaborations)', 'Yes, but only gifted/unpaid' => 'Yes, but only gifted/unpaid', 'No, this would be my first collaboration' => 'No, this would be my first collaboration'];
    }

    public static function partnershipTypes(): array
    {
        return ['Affiliate commissions' => 'Affiliate commissions', 'Paid content creation' => 'Paid content creation', 'Gifted products' => 'Gifted products', 'Long-term brand ambassador role' => 'Long-term brand ambassador role', 'One-off campaign collaborations' => 'One-off campaign collaborations'];
    }

    public static function payoutMethods(): array
    {
        return ['Bank transfer' => 'Bank transfer', 'PayPal' => 'PayPal', 'E-wallet' => 'E-wallet', 'Store credits / vouchers' => 'Store credits / vouchers', 'Open to discussion' => 'Open to discussion'];
    }

    public static function exclusiveOptions(): array
    {
        return ['Yes, for the right fit' => 'Yes, for the right fit', 'No, I prefer to stay non-exclusive' => 'No, I prefer to stay non-exclusive', 'Open to discussion' => 'Open to discussion'];
    }

    public static function brandStatuses(): array
    {
        return ['active' => 'Active', 'paused' => 'Paused', 'archived' => 'Archived'];
    }

    public static function campaignTypes(): array
    {
        return ['affiliate' => 'Affiliate', 'paid_content' => 'Paid content', 'gifted' => 'Gifted', 'ambassador' => 'Ambassador'];
    }

    public static function campaignStatuses(): array
    {
        return ['draft' => 'Draft', 'recruiting' => 'Recruiting', 'active' => 'Active', 'completed' => 'Completed', 'paused' => 'Paused'];
    }

    public static function affiliateLinkStatuses(): array
    {
        return ['active' => 'Active', 'paused' => 'Paused', 'expired' => 'Expired'];
    }

    public static function conversionStatuses(): array
    {
        return ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'];
    }

    public static function payoutStatuses(): array
    {
        return ['pending' => 'Pending', 'scheduled' => 'Scheduled', 'paid' => 'Paid', 'failed' => 'Failed'];
    }

    public static function taskStatuses(): array
    {
        return ['open' => 'Open', 'in_progress' => 'In progress', 'done' => 'Done'];
    }

    public static function priorities(): array
    {
        return ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
    }
}
