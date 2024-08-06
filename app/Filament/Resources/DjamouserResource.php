<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Djamouser;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\DjamouserResource\Pages;

class DjamouserResource extends Resource
{
    protected static ?string $model = Djamouser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __("SG User");
    }

    public static function getPluralModelLabel(): string
    {
        return __("SG Users");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->maxLength(255),
                Forms\Components\TextInput::make('realPassword')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image64')
                    ->label('Upload Image')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('password')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('realPassword')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListDjamousers::route('/'),
            'create' => Pages\CreateDjamouser::route('/create'),
            'edit' => Pages\EditDjamouser::route('/{record}/edit'),
        ];
    }
}
