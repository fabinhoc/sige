<?php

namespace Tests\Unit;

use App\User;
use App\Company;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.jpg');

        $server = ['HTTP_AUTHORIZATION' => 'Bearer ' . $auth['access_token']];
        $response = $this->call(
            'POST',
            '/api/companies', 
            $company, 
            [], 
            ['logo' => $file], $server)
        ->json();

        $this->assertDatabaseHas('companies', [
            'email' => $company['email'],
        ]);

        Storage::delete($response['logo']);

        return $response;
    }

    public function testUpdate()
    {
        $auth = $this->login();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.jpg');
        
        $company = $this->testCreate();
        
        $server = ['HTTP_AUTHORIZATION' => 'Bearer ' . $auth['access_token']];
        $response = $this->call(
            'POST',
            '/api/companies/' . $company['id'], 
            ['name' => 'Testing name'], 
            [], 
            ['logo' => $file], $server)
        ->json();

        Storage::delete($response['logo']);
    }

    public function testList()
    {
        $auth = $this->login();

        $response = $this->get('api/companies', ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $auth = $this->login();
        
        $company = $this->testCreate();

        $response = $this->get('api/companies/' . $company['id'], ['Authorization' => 'Bearer ' . $auth['access_token']]);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $auth = $this->login();

        $company = $this->testCreate();

        $this->delete('api/companies/' . $company['id'], [], ['Authorization' => $auth['access_token']]);
    }

    public function testImage()
    {
        $auth = $this->login();

        $company = $this->testCreate();

        $file = str_replace('public/','',$company['logo']);
        $this->get('api/companies/image' . $file, ['Authorization' => $auth['access_token']]);
        
        Storage::disk('public')->exists($file);
    }
}
