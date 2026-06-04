<?php

namespace App\Filament\Resources\Brands\Tables;

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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('industry')->badge()->sortable(),
                TextColumn::make('country_region')->sortable(),
                TextColumn::make('contact_email')->searchable()->toggleable(),
                TextColumn::make('status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::brandStatuses()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'name' => $data['name'].' Copy']),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::ThreeExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::brandStatuses())->placeholder('No change'),
                            Select::make('country_region')->options(AdminOptions::countries())->placeholder('No change'),
                            TextInput::make('industry')->maxLength(255),
                            TextInput::make('contact_email')->email()->maxLength(255),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Brands updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->name = $record->name.' Copy';
                            $copy->save();
                        });
                        Notification::make()->title('Brands duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
