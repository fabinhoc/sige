<?php

namespace Tests\Unit;

use App\User;
use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected $json = [
        'id',
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
        'complement',
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

        $client = factory(Client::class)->make()->toArray();
        
        $response = $this->post('api/clients', $client, ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', [
            'email' => $client['email'],
        ]);

        return (array) json_decode($response->content());
    }

    public function testUpdate()
    {
        $auth = $this->login();

        $client = $this->testCreate();

        $response = $this->put('api/clients/' . $client['id'], ['name' => 'Fabio Cruz'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $this->assertDatabaseHas('clients', [
            'email' => $client['email'],
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->json);
    }

    public function testList()
    {
        $auth = $this->login();

        $response = $this->get('api/clients', ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $auth = $this->login();
        
        $client = $this->testCreate();

        $response = $this->get('api/clients/' . $client['id'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $auth = $this->login();

        $client = $this->testCreate();

        $this->delete('api/clients/' . $client['id'], [], ['Authorization' => $auth['access_token']]);
    }
}
