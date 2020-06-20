<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $json = [
        'id',
        'name',
        'email',
        'email_verified_at',
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
        
        $user = factory(User::class)->make()->toArray();

        $user['password'] = 'admin'; // admin password to test HASH::Check
        
        $response = $this->post('api/users', $user, ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);

        return (array) json_decode($response->content());
    }

    public function testUpdate()
    {
        $auth = $this->login();

        $user = $this->testCreate();

        $response = $this->put('api/users/' . $user['id'], ['name' => 'Fabio Cruz'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->json);
    }

    public function testList()
    {
        $auth = $this->login();

        $response = $this->get('api/users', ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $auth = $this->login();
        
        $user = $this->testCreate();

        $response = $this->get('api/users/' . $user['id'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $auth = $this->login();

        $user = $this->testCreate();

        $this->delete('api/user/' . $user['id'], [], ['Authorization' => $auth['access_token']]);
    }
}
