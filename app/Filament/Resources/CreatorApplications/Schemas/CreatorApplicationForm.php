<?php

namespace App\Filament\Resources\CreatorApplications\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CreatorApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Applicant')
                    ->schema([
                        TextInput::make('full_name')->required()->maxLength(255),
                        TextInput::make('email')->email()->required()->maxLength(255),
                        Select::make('country_region')->options(AdminOptions::countries())->placeholder('Choose country')->required(),
                        Select::make('discovery_source')->options(AdminOptions::sources())->placeholder('Choose source'),
                        Select::make('status')->options(AdminOptions::statuses())->placeholder('Choose status')->required(),
                        TextInput::make('fit_score')->numeric()->minValue(0)->maxValue(100)->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Audience and Content')
                    ->schema([
                        Select::make('primary_platform')->options(AdminOptions::platforms())->placeholder('Choose platform')->required(),
                        Select::make('follower_range')->options(AdminOptions::followerRanges())->placeholder('Choose range')->required(),
                        Select::make('engagement_rate')->options(AdminOptions::engagementRates())->placeholder('Choose rate'),
                        CheckboxList::make('content_niches')->options(AdminOptions::niches())->columns(2)->columnSpanFull()->required(),
                        Textarea::make('content_style')->required()->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Portfolio')
                    ->schema([
                        Select::make('collaboration_experience')->options(AdminOptions::collaborationLevels())->placeholder('Choose experience')->required(),
                        Textarea::make('past_brand_collaborations')->columnSpanFull(),
                        TextInput::make('best_branded_content_url')->url()->maxLength(255),
                        TextInput::make('portfolio_url')->url()->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Commercial Preferences')
                    ->schema([
                        CheckboxList::make('partnership_preferences')->options(AdminOptions::partnershipTypes())->columns(2)->columnSpanFull()->required(),
                        Select::make('commission_payout_preference')->options(AdminOptions::payoutMethods())->placeholder('Choose payout method')->required(),
                        TextInput::make('minimum_paid_post_rate')->maxLength(255),
                        Select::make('exclusive_partnership_preference')->options(AdminOptions::exclusiveOptions())->placeholder('Choose preference'),
                        Toggle::make('age_confirmed')->required(),
                        Textarea::make('notes')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function statuses(): array
    {
        return AdminOptions::statuses();
    }

    public static function platforms(): array
    {
        return AdminOptions::platforms();
    }

    public static function countries(): array
    {
        return AdminOptions::countries();
    }

    public static function sources(): array
    {
        return AdminOptions::sources();
    }

    public static function followerRanges(): array
    {
        return AdminOptions::followerRanges();
    }

    public static function engagementRates(): array
    {
        return AdminOptions::engagementRates();
    }

    public static function niches(): array
    {
        return AdminOptions::niches();
    }

    public static function collaborationLevels(): array
    {
        return AdminOptions::collaborationLevels();
    }

    public static function partnershipTypes(): array
    {
        return AdminOptions::partnershipTypes();
    }

    public static function payoutMethods(): array
    {
        return AdminOptions::payoutMethods();
    }

    public static function exclusiveOptions(): array
    {
        return AdminOptions::exclusiveOptions();
    }
}
