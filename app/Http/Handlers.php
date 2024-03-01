<?php

namespace App\Http;

use App\Traits\HttpResponse;
use App\Transformers\DefaultTransformer;
use Illuminate\Routing\Router;


class Handlers
{
    use HttpResponse;

    const POST = 'post';
    const GET = 'get';
    const DELETE = 'delete';
    const PATCH = 'patch';
    const PUT = 'put';
    public static ?string $uri = '/';
    public static string $method = 'get';
    public static ?string $resource = null;
    protected static string $keyName = 'id';
    protected static bool $public = false;

    public static function route(Router $router)
    {
        $method = static::getMethod();

        $router
            ->$method(static::$uri, [static::class, 'handler'])
            ->name(static::getKebabClassName())
            ->middleware(static::getRouteMiddleware());
    }

    public static function getMethod()
    {
        return static::$method;
    }

    public static function getKebabClassName()
    {
        return str(str(static::class)->beforeLast('Handler')->explode('\\')->last())->kebab();
    }

    public static function getRouteMiddleware(): array
    {
        if (static::isPublic()) {
            return [];
        }

        return [
            'jwt.auth' . ':' . static::stringifyAbility(),
        ];
    }

    public static function isPublic(): bool
    {
        return static::$public;
    }

    public static function stringifyAbility()
    {
        return implode(',', static::getAbility());
    }

    public static function getAbility(): array
    {
        return [
            str(str(static::getModel())->explode('\\')->last())->kebab() . ':' . static::getKebabClassName(),
        ];
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public static function getApiTransformer(): ?string
    {
        if (!method_exists(static::$resource, 'getApiTransformer')) {
            return DefaultTransformer::class;
        }

        return static::$resource::getApiTransformer();
    }

    public static function getKeyName(): ?string
    {
        return static::$keyName;
    }
}
