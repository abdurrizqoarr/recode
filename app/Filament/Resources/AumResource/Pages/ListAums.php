<?php

namespace App\Filament\Resources\AumResource\Pages;

use App\Filament\Resources\AumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAums extends ListRecords
{
    protected static string $resource = AumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
