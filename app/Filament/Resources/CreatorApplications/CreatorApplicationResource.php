<?php

namespace App\Filament\Resources\CreatorApplications;

use App\Filament\Resources\CreatorApplications\Pages\CreateCreatorApplication;
use App\Filament\Resources\CreatorApplications\Pages\EditCreatorApplication;
use App\Filament\Resources\CreatorApplications\Pages\ListCreatorApplications;
use App\Filament\Resources\CreatorApplications\Schemas\CreatorApplicationForm;
use App\Filament\Resources\CreatorApplications\Tables\CreatorApplicationsTable;
use App\Models\CreatorApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CreatorApplicationResource extends Resource
{
    protected static ?string $model = CreatorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CreatorApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CreatorApplicationsTable::configure($table);
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
            'index' => ListCreatorApplications::route('/'),
            'create' => CreateCreatorApplication::route('/create'),
            'edit' => EditCreatorApplication::route('/{record}/edit'),
        ];
    }
}
