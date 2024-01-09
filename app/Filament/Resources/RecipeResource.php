<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('title')
                    ->label(__('recipe-resource.field.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label(__('recipe-resource.field.description'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('serving')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('vegan')
                    ->required(),
                Forms\Components\Toggle::make('vegeterian')
                    ->required(),
                Forms\Components\TextInput::make('time_cooking')
                    ->required(),
                Forms\Components\TextInput::make('time_rest')
                    ->required(),
                Forms\Components\TextInput::make('time_preparation')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('serving')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('vegan')
                    ->boolean(),
                Tables\Columns\IconColumn::make('vegeterian')
                    ->boolean(),
                Tables\Columns\TextColumn::make('time_cooking'),
                Tables\Columns\TextColumn::make('time_rest'),
                Tables\Columns\TextColumn::make('time_preparation'),
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
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }

//    public static function getNavigationLabel(): string
//    {
//        return __('event-resource.nav.role.label');
//    }
//
//    public static function getNavigationIcon(): string
//    {
//        return __('event-resource.nav.role.icon');
//    }
//
//
//    public static function getModelLabel(): string
//    {
//        return __('event-resource.resource.label.user');
//    }

}
