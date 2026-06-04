<?php

namespace App\Filament\Resources\Payouts\Tables;

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

class PayoutsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('creatorApplication.full_name')->label('Creator')->searchable(),
                TextColumn::make('amount')->money('MYR')->sortable(),
                TextColumn::make('method')->badge()->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('scheduled_for')->date()->sortable(),
                TextColumn::make('paid_at')->date()->sortable(),
                TextColumn::make('reference')->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::payoutStatuses()),
                SelectFilter::make('method')->options(AdminOptions::payoutMethods()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'status' => 'pending', 'paid_at' => null, 'reference' => null]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::ThreeExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::payoutStatuses())->placeholder('No change'),
                            Select::make('method')->options(AdminOptions::payoutMethods())->placeholder('No change'),
                            TextInput::make('amount')->numeric()->prefix('RM'),
                            TextInput::make('currency')->maxLength(3),
                            DatePicker::make('scheduled_for'),
                            DatePicker::make('paid_at'),
                            TextInput::make('reference')->maxLength(255),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Payouts updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->status = 'pending';
                            $copy->paid_at = null;
                            $copy->reference = null;
                            $copy->save();
                        });
                        Notification::make()->title('Payouts duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
