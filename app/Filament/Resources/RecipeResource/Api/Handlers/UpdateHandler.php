<?php

namespace App\Filament\Resources\RecipeResource\Api\Handlers;

use App\Filament\Resources\RecipeResource;
use App\Http\Handlers;
use Illuminate\Http\Request;

class UpdateHandler extends Handlers
{
    public static string|null $uri = '/{id}';
    public static string|null $resource = RecipeResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public function handler(Request $request, $id)
    {
        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());
        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
