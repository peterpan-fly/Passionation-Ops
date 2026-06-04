<?php

namespace App\Filament\Resources\SocialProfiles\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SocialProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Channel')
                    ->schema([
                        Select::make('creator_application_id')->relationship('creatorApplication', 'full_name')->searchable()->preload()->placeholder('Choose creator')->required(),
                        Select::make('platform')->options(AdminOptions::platforms())->placeholder('Choose platform')->required(),
                        TextInput::make('handle')->maxLength(255),
                        TextInput::make('url')->url()->maxLength(255),
                        TextInput::make('followers')->numeric()->minValue(0)->required(),
                        TextInput::make('engagement_rate')->numeric()->suffix('%'),
                        Toggle::make('is_primary'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
