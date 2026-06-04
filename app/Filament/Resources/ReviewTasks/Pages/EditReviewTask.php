<?php

namespace App\Filament\Resources\ReviewTasks\Pages;

use App\Filament\Resources\ReviewTasks\ReviewTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReviewTask extends EditRecord
{
    protected static string $resource = ReviewTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
