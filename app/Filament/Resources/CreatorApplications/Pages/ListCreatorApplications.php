<?php

namespace App\Filament\Resources\CreatorApplications\Pages;

use App\Filament\Resources\CreatorApplications\CreatorApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCreatorApplications extends ListRecords
{
    protected static string $resource = CreatorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
