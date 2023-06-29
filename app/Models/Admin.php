<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Auth
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];
    public function role():HasMany
    {
        return $this->hasMany(Role::class, 'id', 'role_id');
    }
    public function abilities():BelongsToMany
    {
        return $this->belongsToMany(Ability::class, 'roles', 'id', 'role_id');
    }
    public function isAdmin()
    {
        return $this->role_id == 1;
    }
    public function isModeler()
    {
        return $this->role_id == 2;
    }
    public function isFinLvlOne()
    {
        return $this->role_id == 3;
    }
    public function isFinLvlTwo()
    {
        return $this->role_id == 4;
    }
}
