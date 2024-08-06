<?php

namespace App\Filament\Widgets;

use App\Models\Djamouser;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestDjamosUsers extends BaseWidget
{
    protected static ?int $sort = 3;

      protected static ?string $heading = "Latest SG User";

    public function table(Table $table): Table
    {
        return $table
            ->query(Djamouser::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('password'),
            ]);
    }
}
