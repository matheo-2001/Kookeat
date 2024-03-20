<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RecipeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    protected static function booted(): void
    {
        static::saved(function (RecipeCategory $recipeCategory) {
            if (array_key_exists('image', $recipeCategory->getChanges()) && $recipeCategory->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($recipeCategory->getOriginal()['image']);
            }
        });

        static::deleted(function (RecipeCategory $recipeCategory) {
            if ($recipeCategory->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($recipeCategory->getOriginal()['image']);
            }
        });
    }

    public function recipes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }
}
