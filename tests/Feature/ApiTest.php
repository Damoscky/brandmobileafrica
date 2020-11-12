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

    /**
     * @test
     * @group api
     */
    public function testGetAllQuestion()
    {
        $response = $this->get('/question');
        $response->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }

    /**
     * @test
     * @group api
     */
    public function testStoreQuestion()
    {
        $response = $this->postJson('/question/store', [
            'category_id' => 1,
            'question' => '',
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'error' => false
            ]);
    }
}
