<?php

namespace App\Filament\Resources\DjamouserResource\Pages;

use App\Filament\Resources\DjamouserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDjamouser extends EditRecord
{
    protected static string $resource = DjamouserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
