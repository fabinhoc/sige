<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected $json = [
        'id',
        'name',
        'email',
        'logo',
        'website',
        'created_at', 
        'updated_at'
    ];
   
    
}
