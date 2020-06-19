<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'logo', 'website'
    ];

    /**
     * Related App\Client::class
     *
     * @return HasMany
     */
    public function company()
    {
        return $this->hasMany(Client::class, 'company_id', 'id');
    }
}
