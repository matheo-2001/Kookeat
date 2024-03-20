<?php

namespace App\Models;

use App\Services\UserService;
use Aws\S3\S3Client;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'time_cooking',
        'time_rest',
        'time_preparation',
        'difficulty',
        'number_person',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Recipe $recipe) {
            $userId = UserService::getUserId();
            $email = UserService::getEmail();
            $user = User::where('jwt_auth_id', $userId)->first();
            if (!$user) {
                $user = User::create([
                    "name" => $userId,
                    "email" => $email,
                    "password" => bin2hex(random_bytes(60 / 2)),
                    "jwt_auth_id" => $userId
                ]);

            }
            $recipe->user_id = $user->id;


        });

        static::updating(function (Recipe $recipe) {
//            ajouter le role modo
            $userModo = auth()->check();
            if ($recipe->user?->jwt_auth_id != UserService::getUserId() && !$userModo) {
//                traduction erreur
                abort(Response::HTTP_FORBIDDEN, 'Vous n\'avez pas le droit de modifier cette recette');
            }
        });

        static::deleting(function (Recipe $recipe) {
//            ajouter le role modo
            $userModo = auth()->check();
            if ($recipe->user?->jwt_auth_id != UserService::getUserId() && !$userModo) {
//                traduction erreur
                abort(Response::HTTP_FORBIDDEN, 'Vous n\'avez pas le droit de supprimer cette recette');
            }
        });

        static::saving(function (Recipe $recipe) {
            if (!$recipe->exists || $recipe->getOriginal()['image'] !== $recipe->image) {
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region' => 'eu-west-3', // Remplacez par votre région S3
                    'credentials' => [
                        'key' => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);

                $bucket = env('AWS_BUCKET'); // Nom de votre bucket S3
                $key = $recipe->image; // Chemin de l'image dans S3

                // Récupérer le contenu de l'image depuis S3
                $result = $s3Client->getObject([
                    'Bucket' => $bucket,
                    'Key' => $key,
                ]);
                $client = new Client();
                $response = $client->request('POST', 'http://fastapi/predict/', [
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $result['Body']->getContents(),
                            'filename' => basename($recipe->image)
                        ],
                    ],
                ]);
                $content = json_decode($response->getBody());

                if ($content->prediction === "other") {
                    Storage::disk('s3')->delete($recipe->image);
                    abort(403, 'Veuillez mettre une photo correspondant à une recette');
                }

            }

        });

        static::saved(function (Recipe $recipe) {
            if (array_key_exists('image', $recipe->getChanges()) && $recipe->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($recipe->getOriginal()['image']);
            }
        });

        static::deleted(function (Recipe $recipe) {
            if ($recipe->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($recipe->getOriginal()['image']);
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

    public function recipeSteps(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RecipeStep::class);
    }

    public function equipments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Equipment::class);
    }
}
