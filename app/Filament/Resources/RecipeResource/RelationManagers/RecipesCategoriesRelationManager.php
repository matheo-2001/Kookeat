<?php

namespace App\Filament\Resources\RecipeResource\RelationManagers;

use App\Filament\Resources\RecipeCategoryResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RecipesCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'recipesCategories';

    public function form(Form $form): Form
    {
        return RecipeCategoryResource::form($form);
    }

    public function table(Table $table): Table
    {
        return RecipeCategoryResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
