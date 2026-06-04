<?php

namespace App\Filament\Resources\Payouts\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PayoutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payout')
                    ->schema([
                        Select::make('creator_application_id')->relationship('creatorApplication', 'full_name')->searchable()->preload()->placeholder('Choose creator')->required(),
                        TextInput::make('amount')->numeric()->prefix('RM')->required(),
                        TextInput::make('currency')->default('MYR')->maxLength(3)->required(),
                        Select::make('method')->options(AdminOptions::payoutMethods())->placeholder('Choose method')->required(),
                        Select::make('status')->options(AdminOptions::payoutStatuses())->placeholder('Choose status')->required(),
                        DatePicker::make('scheduled_for'),
                        DatePicker::make('paid_at'),
                        TextInput::make('reference')->maxLength(255),
                        Textarea::make('notes')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
