<?php

namespace App\Filament\Resources\RecipeResource\Api\Handlers;

use App\Filament\Resources\RecipeResource;
use App\Http\Handlers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName();
            $filePath = 'recipe/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $model->image = $filePath;
        }
        try {
            $model->save();
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Veuillez mettre une photo correspondant à une recette'], 403);
        }

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }
}
