<?php

namespace App\Filament\Resources\AdminAumResource\Pages;

use App\Filament\Resources\AdminAumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminAums extends ListRecords
{
    protected static string $resource = AdminAumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
