<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercice extends Model
{
    use HasFactory;

     // ONE TO MANY
     public function comment(): HasMany
     {
         return $this->hasMany(Comment::class);
     }

    // MANY TO ONE
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // MANY TO ONE
    public function multimedia(): BelongsTo
    {
        return $this->belongsTo(Multimedia::class);
    }

    // MANY TO ONE
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    protected $fillable = [
        'name',
        'category_id',
        'serie',
        'difficulty',
        'instructions',
        'time',
        'level'
    ];


}
