<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    // ONE TO ONE
    public function multimedia() {

        return $this->belongsTo (Multimedia::class);
    }

    // ONE TO MANY
    public function exercice(): HasMany
    {
        return $this->hasMany(Exercice::class);
    }

    // ONE TO MANY
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // MANY TO MANY
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

// Les champs suivants sont renvoyés en base de données
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gender',
        'lastname',
        'firstname',
        'age',
        'role',
        'level',
        'email',
        'password',
        'number',
        'updated_at',
        'created_at',
        'multimedia_id'
    ];

// Les champs suivants sont non visibles pour des raisons de confidentialités
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
