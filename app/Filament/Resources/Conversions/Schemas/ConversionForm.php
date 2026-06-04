<?php

namespace App\Filament\Resources\Conversions\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConversionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Conversion')
                    ->schema([
                        Select::make('affiliate_link_id')->relationship('affiliateLink', 'code')->searchable()->preload()->placeholder('Choose affiliate code')->required(),
                        TextInput::make('order_reference')->required()->maxLength(255),
                        TextInput::make('order_value')->numeric()->prefix('RM')->required(),
                        TextInput::make('commission_amount')->numeric()->prefix('RM')->required(),
                        Select::make('status')->options(AdminOptions::conversionStatuses())->placeholder('Choose status')->required(),
                        DateTimePicker::make('converted_at'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
