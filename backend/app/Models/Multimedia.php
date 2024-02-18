<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Multimedia extends Model
{
    use HasFactory;

    // ONE TO ONE
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    // ONE TO ONE
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ONE TO MANY
    public function exercices(): HasMany
    {
        return $this->hasMany(Exercice::class);
    }

}
