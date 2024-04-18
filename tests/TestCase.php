<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    protected $headers;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createUser();
    }

    protected function createUser(): void
    {
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }
    
    protected function setHeaders(User $user): void
    {
        $accessToken = $user->createToken('laravel_api_token')->plainTextToken;
        $this->headers = ['Authorization' => "Bearer $accessToken"];
    }
}
