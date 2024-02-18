<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    // ONE TO ONE
    public function multimedia(): HasOne
    {
        return $this->hasOne(Multimedia::class);
    }

    // ONE TO MANY
    public function exercice() : HasMany
    {
        return $this->hasMany(Exercice::class);
    }

     // MANY TO MANY
     public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
