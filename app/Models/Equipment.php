<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    protected static function booted(): void
    {
        static::saved(function (Equipment $equipment) {
            if (array_key_exists('image', $equipment->getChanges()) && $equipment->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($equipment->getOriginal()['image']);
            }
        });

        static::deleted(function (Equipment $equipment) {
            if ($equipment->getOriginal()['image'] !== null) {
                Storage::disk('s3')->delete($equipment->getOriginal()['image']);
            }
        });
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function recipes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }
}
