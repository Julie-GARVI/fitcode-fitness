<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    public function categories()
{
    return $this->belongsToMany(Category::class);
}

    public function category() {

        return $this->belongsTo(Category::class);
        }

    public function multimedia() {

        return $this->belongsTo (Multimedia::class);
        }

    public function exercice(): HasMany
    {
        return $this->hasMany(Exercice::class);
    }

// Les champs suivants sont renvoyés en base de données
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'is_admin'
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
