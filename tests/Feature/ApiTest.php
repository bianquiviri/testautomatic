<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function Ist_Alive_Test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function end_point_Test()
    {
        $response = $this->get('/api/employees');
        $response->assertStatus(200);
    }

}
