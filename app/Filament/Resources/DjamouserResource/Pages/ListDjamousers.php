<?php

namespace App\Filament\Resources\DjamouserResource\Pages;

use App\Filament\Resources\DjamouserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDjamousers extends ListRecords
{
    protected static string $resource = DjamouserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
