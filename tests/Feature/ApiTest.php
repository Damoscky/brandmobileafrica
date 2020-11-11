<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     * @group api
     */
    public function testHello()
    {
        $response = $this->get('/api/v1/test');
        $response->assertOk();
    }
}
