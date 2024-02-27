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
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('recipe-resource.section.recipe_information'))
                            ->schema([
//                                Forms\Components\Select::make('user_id')
//                                    ->relationship('user', 'name'),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->imageEditor()
                                    ->label(__('recipe-resource.field.image'))
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\TextInput::make('title')
                                    ->label(__('recipe-resource.field.title'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label(__('recipe-resource.field.description'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('serving')
                                    ->label(__('recipe-resource.field.serving'))
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Toggle::make('vegan')
                                    ->label(__('recipe-resource.field.vegan'))
                                    ->required(),
                                Forms\Components\Toggle::make('vegeterian')
                                    ->label(__('recipe-resource.field.vegan'))
                                    ->required(),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('recipe-resource.section.time'))
                            ->schema([
                                Forms\Components\TimePicker::make('time_cooking')
                                    ->label(__('recipe-resource.field.time_cooking'))
                                    ->required(),
                                Forms\Components\TimePicker::make('time_rest')
                                    ->label(__('recipe-resource.field.time_rest'))
                                    ->required(),
                                Forms\Components\TimePicker::make('time_preparation')
                                    ->label(__('recipe-resource.field.time_preparation'))
                                    ->required(),
                            ])
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('recipe-resource.column.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('recipe-resource.column.description'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('recipe-resource.column.image')),
                Tables\Columns\TextColumn::make('serving')
                    ->label(__('recipe-resource.column.serving'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('vegan')
                    ->label(__('recipe-resource.column.vegan'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('vegeterian')
                    ->label(__('recipe-resource.column.vegeterian'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('time_cooking')
                    ->label(__('recipe-resource.column.time_cooking')),
                Tables\Columns\TextColumn::make('time_rest')
                    ->label(__('recipe-resource.column.time_rest')),
                Tables\Columns\TextColumn::make('time_preparation')
                    ->label(__('recipe-resource.column.time_preparation')),
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

    public static function getNavigationLabel(): string
    {
        return __('recipe-resource.nav.role.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('recipe-resource.nav.role.icon');
    }


    public static function getModelLabel(): string
    {
        return __('recipe-resource.resource.label.user');
    }

}
