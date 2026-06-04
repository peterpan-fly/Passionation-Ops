<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign')
                    ->schema([
                        Select::make('brand_id')->relationship('brand', 'name')->searchable()->preload()->placeholder('Choose brand')->required(),
                        TextInput::make('name')->required()->maxLength(255),
                        Select::make('campaign_type')->options(AdminOptions::campaignTypes())->placeholder('Choose type')->required(),
                        Select::make('status')->options(AdminOptions::campaignStatuses())->placeholder('Choose status')->required(),
                        TextInput::make('commission_rate')->numeric()->suffix('%')->required(),
                        TextInput::make('flat_fee_budget')->numeric()->prefix('RM')->required(),
                        DatePicker::make('starts_at'),
                        DatePicker::make('ends_at'),
                        CheckboxList::make('target_niches')->options(AdminOptions::niches())->columns(2)->columnSpanFull(),
                        CheckboxList::make('target_countries')->options(AdminOptions::countries())->columns(2)->columnSpanFull(),
                        Textarea::make('brief')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
