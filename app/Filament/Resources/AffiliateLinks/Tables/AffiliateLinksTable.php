<?php

namespace App\Filament\Resources\AffiliateLinks\Tables;

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

class AffiliateLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->copyable()->sortable(),
                TextColumn::make('creatorApplication.full_name')->label('Creator')->searchable(),
                TextColumn::make('campaign.name')->label('Campaign')->searchable(),
                TextColumn::make('clicks')->numeric()->sortable(),
                TextColumn::make('conversions_count')->numeric()->sortable(),
                TextColumn::make('revenue')->money('MYR')->sortable(),
                TextColumn::make('status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::affiliateLinkStatuses()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'code' => $data['code'].'-COPY-'.strtoupper(substr(uniqid(), -4)), 'clicks' => 0, 'conversions_count' => 0, 'revenue' => 0]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::FourExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::affiliateLinkStatuses())->placeholder('No change'),
                            Select::make('campaign_id')->relationship('campaign', 'name')->searchable()->preload()->placeholder('No change'),
                            TextInput::make('destination_url')->url()->maxLength(255),
                            TextInput::make('clicks')->numeric()->minValue(0),
                            TextInput::make('conversions_count')->numeric()->minValue(0),
                            TextInput::make('revenue')->numeric()->prefix('RM'),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Affiliate links updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->code = $record->code.'-COPY-'.strtoupper(substr(uniqid(), -4));
                            $copy->clicks = 0;
                            $copy->conversions_count = 0;
                            $copy->revenue = 0;
                            $copy->save();
                        });
                        Notification::make()->title('Affiliate links duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
