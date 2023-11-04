<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;


    // Définit une relation many to one avec User
    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    // Définit une relation many to one avec Category
    public function category(): BelongsTo
    {
    return $this->belongsTo(Category::class);
    }

     // Définit une relation many to one avec Multimedia
    public function multimedia(): BelongsTo
    {
    return $this->belongsTo(Multimedia::class);
    }


    protected $fillable = [
        'name',
        'category_id',
        'serie',
        'difficulty',
        'instructions',
        'time'
    ];


}
