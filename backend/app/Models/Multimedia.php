<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Multimedia extends Model
{
    use HasFactory;

    // Définit une relation many to many avec user
    public function user(): HasMany
{
    return $this->hasMany(User::class);
}

    // Définit une relation one to many avec exercice
    public function exercices(): HasMany
    {
    return $this->hasMany(Exercice::class);
    }

    public function category(): BelongsTo
    {
    return $this->belongsTo(Category::class);
    }

}
