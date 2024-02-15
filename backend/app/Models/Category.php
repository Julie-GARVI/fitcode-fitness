<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;


    public function exercice() : HasMany
    {
        return $this->hasMany(Exercice::class);
    }

    public function user(): HasMany
    {
     return $this->hasMany(User::class);
    }

    public function multimedia(): HasOne
    {
     return $this->hasOne(Multimedia::class);
    }
}
