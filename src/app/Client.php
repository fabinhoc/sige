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
        'complement'
    ];

    /**
     * Related App\ProductComment::class
     *
     * @return BelongsTo
     */
    public function compnay()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
