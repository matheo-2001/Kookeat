<?php

namespace App\Models;

use App\Services\UserService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'serving',
        'vegan',
        'vegeterian',
        'time_cooking',
        'time_rest',
        'time_preparation',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Recipe $recipe) {
            $userId = UserService::getUserId();
            $email = UserService::getEmail();

            $userExist = User::where('jwt_auth_id', $userId)->exists();
            if (!$userExist) {
                $user = User::create([
                    "name" => $userId,
                    "email" => $email,
                    "password" => bin2hex(random_bytes(60 / 2)),
                    "jwt_auth_id" => $userId
                ]);
                $recipe->user_id = $user->id;
            }
        });

        static::updating(function (Recipe $recipe) {
//            ajouter le role modo
            $userModo = auth()->check();
            if ($recipe->user->jwt_auth_id != UserService::getUserId() && !$userModo) {
//                traduction erreur
                abort(Response::HTTP_FORBIDDEN, 'Vous n\'avez pas le droit de modifier cette recette');
            }
        });

        static::deleting(function (Recipe $recipe) {
//            ajouter le role modo
            $userModo = auth()->check();
            if ($recipe->user->jwt_auth_id != UserService::getUserId() && !$userModo) {
//                traduction erreur
                abort(Response::HTTP_FORBIDDEN, 'Vous n\'avez pas le droit de supprimer cette recette');
            }
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Favorite::class, 'recipe_id');
    }

    public function ingredients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function recipesCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RecipeCategory::class);
    }
}
