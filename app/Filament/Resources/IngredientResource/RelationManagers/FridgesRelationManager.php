<?php

namespace App\Filament\Resources\IngredientResource\RelationManagers;

use App\Filament\Resources\FridgeResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FridgesRelationManager extends RelationManager
{
    protected static string $relationship = 'fridges';

    public function form(Form $form): Form
    {
        return FridgeResource::form($form);
    }

    public function table(Table $table): Table
    {
        return FridgeResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
