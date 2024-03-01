<?php

namespace App\Filament\Resources\RecipeResource\Api\Handlers;

use App\Filament\Resources\RecipeResource;
use App\Http\Handlers;
use Illuminate\Http\Request;

class CreateHandler extends Handlers
{
    public static string|null $uri = '/';
    public static string|null $resource = RecipeResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public function handler(Request $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
