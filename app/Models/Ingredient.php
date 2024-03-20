<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'image',
        'metric_type',
        'ingredient_category_id'
    ];

    protected static function booted(): void
    {
        static::saved(function (Ingredient $ingredient) {
            if (array_key_exists('image', $ingredient->getChanges()) && $ingredient->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($ingredient->getOriginal()['image']);
            }
        });

        static::deleted(function (Ingredient $ingredient) {
            if ($ingredient->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($ingredient->getOriginal()['image']);
            }
        });
    }

    public function ingredientCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IngredientCategory::class, 'ingredient_category_id');
    }

    public function fridges(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Fridge::class);
    }


    public function recipes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }

    public function diets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Diet::class);
    }
}
