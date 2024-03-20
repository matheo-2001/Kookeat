<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\EquipmentResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EquipmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'equipments';

    public function form(Form $form): Form
    {
        return EquipmentResource::form($form);
    }

    public function table(Table $table): Table
    {
        return EquipmentResource::table($table)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([])
            ]);
    }
}
