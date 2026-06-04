<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand')
                    ->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('industry')->maxLength(255),
                        Select::make('country_region')->options(AdminOptions::countries())->placeholder('Choose country'),
                        TextInput::make('website')->url()->maxLength(255),
                        TextInput::make('contact_name')->maxLength(255),
                        TextInput::make('contact_email')->email()->maxLength(255),
                        Select::make('status')->options(AdminOptions::brandStatuses())->placeholder('Choose status')->required(),
                        Textarea::make('notes')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
