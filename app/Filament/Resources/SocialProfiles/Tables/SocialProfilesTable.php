<?php

namespace App\Filament\Resources\SocialProfiles\Tables;

use App\Support\AdminOptions;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class SocialProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('creatorApplication.full_name')->label('Creator')->searchable()->sortable(),
                TextColumn::make('platform')->badge()->sortable(),
                TextColumn::make('handle')->searchable(),
                TextColumn::make('followers')->numeric()->sortable(),
                TextColumn::make('engagement_rate')->suffix('%')->sortable(),
                IconColumn::make('is_primary')->boolean(),
            ])
            ->filters([
                SelectFilter::make('platform')->options(AdminOptions::platforms()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEditPlatform')
                        ->label('Bulk edit')
                        ->modalWidth(Width::ThreeExtraLarge)
                        ->schema([
                            Grid::make(2)->schema([
                                Select::make('platform')->options(AdminOptions::platforms())->placeholder('No change'),
                                TextInput::make('followers')->numeric()->minValue(0),
                                TextInput::make('engagement_rate')->numeric()->suffix('%'),
                                TextInput::make('handle')->maxLength(255),
                            ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each->update(array_filter($data, fn ($value) => filled($value)));
                            Notification::make()->title('Profiles updated')->success()->send();
                        }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(fn ($record) => $record->replicate()->save());
                        Notification::make()->title('Profiles duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
