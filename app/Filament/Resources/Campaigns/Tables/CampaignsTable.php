<?php

namespace App\Filament\Resources\Campaigns\Tables;

use App\Support\AdminOptions;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\CheckboxList;
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

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('brand.name')->label('Brand')->searchable()->sortable(),
                TextColumn::make('campaign_type')->badge()->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('commission_rate')->suffix('%')->sortable(),
                TextColumn::make('flat_fee_budget')->money('MYR')->sortable(),
                TextColumn::make('starts_at')->date()->sortable(),
                TextColumn::make('ends_at')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(AdminOptions::campaignStatuses()),
                SelectFilter::make('campaign_type')->options(AdminOptions::campaignTypes()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()->mutateRecordDataUsing(fn (array $data): array => [...$data, 'name' => $data['name'].' Copy', 'status' => 'draft']),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkEdit')->label('Bulk edit')->modalWidth(Width::FiveExtraLarge)->schema([
                        Grid::make(2)->schema([
                            Select::make('status')->options(AdminOptions::campaignStatuses())->placeholder('No change'),
                            Select::make('campaign_type')->options(AdminOptions::campaignTypes())->placeholder('No change'),
                            TextInput::make('commission_rate')->numeric()->suffix('%'),
                            TextInput::make('flat_fee_budget')->numeric()->prefix('RM'),
                            DatePicker::make('starts_at'),
                            DatePicker::make('ends_at'),
                            CheckboxList::make('target_niches')->options(AdminOptions::niches())->columns(2)->columnSpanFull(),
                            CheckboxList::make('target_countries')->options(AdminOptions::countries())->columns(2)->columnSpanFull(),
                        ]),
                    ])->action(function (Collection $records, array $data): void {
                        $records->each->update(array_filter($data, fn ($value) => filled($value)));
                        Notification::make()->title('Campaigns updated')->success()->send();
                    }),
                    BulkAction::make('duplicateSelected')->label('Duplicate')->requiresConfirmation()->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $copy = $record->replicate();
                            $copy->name = $record->name.' Copy';
                            $copy->status = 'draft';
                            $copy->save();
                        });
                        Notification::make()->title('Campaigns duplicated')->success()->send();
                    }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
