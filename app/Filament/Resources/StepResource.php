<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StepResource\Pages;
use App\Filament\Resources\StepResource\RelationManagers;
use App\Models\Step;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StepResource extends Resource
{
    protected static ?string $model = Step::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\Select::make('recipe_id')
//                    ->relationship('recipe', 'title')
//                    ->label(__('step-resource.field.title'))
//                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('step-resource.field.description'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recipe.title')
                    ->label(__('step-resource.column.title'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('step-resource.column.description'))
                    ->searchable(),
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
            'index' => Pages\ListSteps::route('/'),
            'create' => Pages\CreateStep::route('/create'),
            'edit' => Pages\EditStep::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('step-resource.nav.role.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('step-resource.nav.role.icon');
    }


    public static function getModelLabel(): string
    {
        return __('step-resource.resource.label.user');
    }
}
