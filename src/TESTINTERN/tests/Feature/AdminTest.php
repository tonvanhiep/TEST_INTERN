<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function csvExportTestWithoutConditions()
    {
        $response = $this->call('POST', '/admin/login', [
            'email' => 'hiepvanton@quanly.com',
            'pass' => '1234567890',
            '_token' => csrf_token()
        ]);
    }
}
