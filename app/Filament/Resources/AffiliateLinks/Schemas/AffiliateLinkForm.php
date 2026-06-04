<?php

namespace App\Filament\Resources\AffiliateLinks\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AffiliateLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Affiliate Link')
                    ->schema([
                        Select::make('creator_application_id')->relationship('creatorApplication', 'full_name')->searchable()->preload()->placeholder('Choose creator')->required(),
                        Select::make('campaign_id')->relationship('campaign', 'name')->searchable()->preload()->placeholder('Choose campaign')->required(),
                        TextInput::make('code')->required()->maxLength(255),
                        TextInput::make('destination_url')->url()->required()->maxLength(255),
                        TextInput::make('clicks')->numeric()->minValue(0)->required(),
                        TextInput::make('conversions_count')->numeric()->minValue(0)->required(),
                        TextInput::make('revenue')->numeric()->prefix('RM')->required(),
                        Select::make('status')->options(AdminOptions::affiliateLinkStatuses())->placeholder('Choose status')->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
