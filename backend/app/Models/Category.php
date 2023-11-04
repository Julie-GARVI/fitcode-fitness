<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function multimedia(): HasMany
    {
     return $this->hasMany(Multimedia::class);
    }
}
