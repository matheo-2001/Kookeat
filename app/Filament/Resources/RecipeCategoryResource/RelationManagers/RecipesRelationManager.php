<?php

namespace App\Filament\Resources\RecipeCategoryResource\RelationManagers;

use App\Filament\Resources\RecipeResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RecipesRelationManager extends RelationManager
{
    protected static string $relationship = 'recipes';

    public function form(Form $form): Form
    {
        return RecipeResource::form($form);
    }

    public function table(Table $table): Table
    {
        return RecipeResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
