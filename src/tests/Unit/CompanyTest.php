<?php

namespace Tests\Unit;

use App\User;
use App\Company;
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
   
    public function login()
    {
        $user = factory(User::class)->create()->toArray();
        
        $user['password'] = 'admin'; // admin password to test HASH::Check
        $response = $this->post('api/login', $user);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);

        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);

        return (array) json_decode($response->content());
    }

    public function testCreate()
    {
        $auth = $this->login();
        
        $company = factory(Company::class)->make()->toArray();

        $response = $this->post('api/companies', $company, ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', [
            'email' => $company['email'],
        ]);

        return (array) json_decode($response->content());
    }

    public function testUpdate()
    {
        $auth = $this->login();

        $company = $this->testCreate();

        $response = $this->put('api/companies/' . $company['id'], ['name' => 'Fabio Cruz'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $this->assertDatabaseHas('companies', [
            'email' => $company['email'],
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->json);
    }

    public function testList()
    {
        $auth = $this->login();

        $response = $this->get('api/companies', ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['*' => $this->json]);
    }

    public function testShow()
    {
        $auth = $this->login();
        
        $company = $this->testCreate();

        $response = $this->get('api/companies/' . $company['id'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->json);
    }

    public function testDestroy()
    {
        $auth = $this->login();

        $company = $this->testCreate();

        $this->delete('api/companies/' . $company['id'], [], ['Authorization' => $auth['access_token']]);
    }
}
