<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

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
