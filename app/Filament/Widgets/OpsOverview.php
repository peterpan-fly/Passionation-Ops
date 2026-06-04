<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use App\Models\Conversion;
use App\Models\CreatorApplication;
use App\Models\Payout;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OpsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Applications', CreatorApplication::count())
                ->description(CreatorApplication::where('status', 'reviewing')->count().' in review'),
            Stat::make('Approved creators', CreatorApplication::where('status', 'approved')->count())
                ->description('Ready for campaign matching'),
            Stat::make('Active campaigns', Campaign::whereIn('status', ['active', 'recruiting'])->count())
                ->description('Recruiting or live'),
            Stat::make('Tracked revenue', 'RM '.number_format((float) Conversion::sum('order_value'), 2))
                ->description('From seeded conversions'),
            Stat::make('Pending payouts', 'RM '.number_format((float) Payout::whereIn('status', ['pending', 'scheduled'])->sum('amount'), 2))
                ->description('Finance queue'),
        ];
    }
}
