<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
{
    use HasFactory;

    public function Ingredients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ingredient::class, 'ingredient_category_id');
    }
}
