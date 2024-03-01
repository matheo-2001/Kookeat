<?php

namespace App\Filament\Resources\RecipeResource\Api\Handlers;

use App\Filament\Resources\RecipeResource;
use App\Http\Handlers;
use App\Services\UserService;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static string|null $uri = '/';
    public static string|null $resource = RecipeResource::class;


    public function handler()
    {
        dd(UserService::getUserId());
        $model = static::getModel();

        $query = QueryBuilder::for($model)
            ->allowedFields($model::$allowedFields ?? [])
            ->allowedSorts($model::$allowedSorts ?? [])
            ->allowedFilters($model::$allowedFilters ?? [])
            ->paginate(request()->query('per_page'))
            ->appends(request()->query());

        return static::getApiTransformer()::collection($query);
    }
}
