<?php

namespace App\Filament\Resources\FridgeResource\RelationManagers;

use App\Filament\Resources\IngredientResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class IngredientsRelationManager extends RelationManager
{
    protected static string $relationship = 'ingredients';

    public function form(Form $form): Form
    {
        return IngredientResource::form($form);
    }

    public function table(Table $table): Table
    {
        return IngredientResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
