<?php

namespace App\Filament\Resources\ReviewTasks\Tables;

use App\Support\AdminOptions;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ReviewTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('creatorApplication.full_name')->label('Creator')->searchable(),
                TextColumn::make('owner')->searchable()->toggleable(),
                TextColumn::make('priority')->badge()->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('due_at')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::taskStatuses()),
                SelectFilter::make('priority')->options(AdminOptions::priorities()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'title' => $data['title'].' Copy', 'status' => 'open']),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::ThreeExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::taskStatuses())->placeholder('No change'),
                            Select::make('priority')->options(AdminOptions::priorities())->placeholder('No change'),
                            TextInput::make('owner')->maxLength(255),
                            DatePicker::make('due_at'),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Tasks updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->title = $record->title.' Copy';
                            $copy->status = 'open';
                            $copy->save();
                        });
                        Notification::make()->title('Tasks duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
