<?php

namespace App\Filament\Resources\ReviewTasks;

use App\Filament\Resources\ReviewTasks\Pages\CreateReviewTask;
use App\Filament\Resources\ReviewTasks\Pages\EditReviewTask;
use App\Filament\Resources\ReviewTasks\Pages\ListReviewTasks;
use App\Filament\Resources\ReviewTasks\Schemas\ReviewTaskForm;
use App\Filament\Resources\ReviewTasks\Tables\ReviewTasksTable;
use App\Models\ReviewTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReviewTaskResource extends Resource
{
    protected static ?string $model = ReviewTask::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ReviewTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReviewTasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReviewTasks::route('/'),
            'create' => CreateReviewTask::route('/create'),
            'edit' => EditReviewTask::route('/{record}/edit'),
        ];
    }
}
