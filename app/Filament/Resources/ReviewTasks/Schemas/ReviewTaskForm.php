<?php

namespace App\Filament\Resources\ReviewTasks\Schemas;

use App\Support\AdminOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task')
                    ->schema([
                        Select::make('creator_application_id')->relationship('creatorApplication', 'full_name')->searchable()->preload()->placeholder('Choose creator')->required(),
                        TextInput::make('title')->required()->maxLength(255),
                        TextInput::make('owner')->maxLength(255),
                        Select::make('priority')->options(AdminOptions::priorities())->placeholder('Choose priority')->required(),
                        Select::make('status')->options(AdminOptions::taskStatuses())->placeholder('Choose status')->required(),
                        DatePicker::make('due_at'),
                        Textarea::make('notes')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
