<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserCanViewLogin()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertViewIs('admin.login')->assertSee('ログイン');
    }

    public function testLoginPost(){

        $response = $this->call('POST', '/admin/login', [
            'email' => 'hiepvanton@quanly.com',
            'pass' => '1234567890',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect('/admin/product');
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        // $user = factory(User::class)->make([
        //     'password' => bcrypt('laravel'),
        // ]);

        $response = $this->call('POST', '/admin/login', [
            'email' => 'hiepvanton@quanly.com',
            'pass' => '1234567890',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect('/admin/login');
        // $response->assertRedirect('/admin/login');
        // $response->assertSessionHasErrors();
        // $this->assertFalse(session()->hasOldInput('email'));
        // $this->assertFalse(session()->hasOldInput('pass'));
        // $this->assertGuest();
    }
}
