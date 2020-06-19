<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'personalNumber', 
        'phone', 
        'company_id',
        'zipcode', 
        'address', 
        'houseNumber',
        'neighborhood',
        'state',
        'city',
        'complement'
    ];

    /**
     * Related App\Company::class
     *
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
