<?php
namespace App\Filament\Resources\RecipeResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\RecipeResource;
use Illuminate\Routing\Router;


class RecipeApiService extends ApiService
{
    protected static string | null $resource = RecipeResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];
        
    }
}
