<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\DietResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DietsRelationManager extends RelationManager
{
    protected static string $relationship = 'diets';

    public function form(Form $form): Form
    {
        return DietResource::form($form);
    }

    public function table(Table $table): Table
    {
        return DietResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
