<?php

namespace App\Filament\Resources\ReviewTasks\Pages;

use App\Filament\Resources\ReviewTasks\ReviewTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReviewTasks extends ListRecords
{
    protected static string $resource = ReviewTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
