<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IngredientCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    protected static function booted(): void
    {
        static::saved(function (IngredientCategory $ingredientCategory) {
            if (array_key_exists('image', $ingredientCategory->getChanges()) && $ingredientCategory->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($ingredientCategory->getOriginal()['image']);
            }
        });

        static::deleted(function (IngredientCategory $ingredientCategory) {
            if ($ingredientCategory->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($ingredientCategory->getOriginal()['image']);
            }
        });
    }


    public function ingredients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ingredient::class, 'ingredient_category_id');
    }
}
