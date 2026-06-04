<?php

namespace App\Filament\Resources\Conversions\Tables;

use App\Support\AdminOptions;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ConversionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_reference')->searchable()->sortable(),
                TextColumn::make('affiliateLink.code')->label('Affiliate code')->searchable(),
                TextColumn::make('order_value')->money('MYR')->sortable(),
                TextColumn::make('commission_amount')->money('MYR')->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('converted_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::conversionStatuses()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'order_reference' => $data['order_reference'].'-COPY-'.strtoupper(substr(uniqid(), -4)), 'status' => 'pending']),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::ThreeExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::conversionStatuses())->placeholder('No change'),
                            TextInput::make('order_value')->numeric()->prefix('RM'),
                            TextInput::make('commission_amount')->numeric()->prefix('RM'),
                            DateTimePicker::make('converted_at'),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Conversions updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->order_reference = $record->order_reference.'-COPY-'.strtoupper(substr(uniqid(), -4));
                            $copy->status = 'pending';
                            $copy->save();
                        });
                        Notification::make()->title('Conversions duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
