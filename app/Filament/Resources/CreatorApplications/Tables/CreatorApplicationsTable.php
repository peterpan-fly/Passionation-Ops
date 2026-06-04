<?php

namespace App\Filament\Resources\CreatorApplications\Tables;

use App\Filament\Resources\CreatorApplications\Schemas\CreatorApplicationForm;
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

class CreatorApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('country_region')->badge()->sortable(),
                TextColumn::make('primary_platform')->badge()->sortable(),
                TextColumn::make('follower_range')->sortable(),
                TextColumn::make('engagement_rate')->toggleable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('fit_score')->numeric()->sortable(),
                IconColumn::make('age_confirmed')->boolean()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(CreatorApplicationForm::statuses()),
                SelectFilter::make('country_region')->options(CreatorApplicationForm::countries()),
                SelectFilter::make('primary_platform')->options(CreatorApplicationForm::platforms()),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make()
                    ->mutateRecordDataUsing(fn (array $data): array => [
                        ...$data,
                        'email' => 'copy+'.uniqid().'@example.com',
                        'full_name' => $data['full_name'].' Copy',
                        'status' => 'new',
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkUpdate')
                        ->label('Bulk edit')
                        ->modalWidth(Width::FiveExtraLarge)
                        ->schema([
                            Grid::make(2)->schema([
                                Select::make('status')->options(AdminOptions::statuses())->placeholder('No change'),
                                TextInput::make('fit_score')->numeric()->minValue(0)->maxValue(100),
                                Select::make('country_region')->options(AdminOptions::countries())->placeholder('No change'),
                                Select::make('primary_platform')->options(AdminOptions::platforms())->placeholder('No change'),
                                Select::make('follower_range')->options(AdminOptions::followerRanges())->placeholder('No change'),
                                Select::make('engagement_rate')->options(AdminOptions::engagementRates())->placeholder('No change'),
                                Select::make('commission_payout_preference')->options(AdminOptions::payoutMethods())->placeholder('No change'),
                                Select::make('exclusive_partnership_preference')->options(AdminOptions::exclusiveOptions())->placeholder('No change'),
                            ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $payload = array_filter($data, fn ($value) => filled($value));
                            $records->each->update($payload);
                            Notification::make()->title('Applications updated')->success()->send();
                        }),
                    BulkAction::make('duplicateSelected')
                        ->label('Duplicate')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $copy = $record->replicate();
                                $copy->email = 'copy+'.uniqid().'@example.com';
                                $copy->full_name = $record->full_name.' Copy';
                                $copy->status = 'new';
                                $copy->save();
                            });
                            Notification::make()->title('Applications duplicated')->success()->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
