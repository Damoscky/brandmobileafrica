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
        $response = $this->get('api/v1/question');
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
        $response = $this->postJson('api/v1/question/store', [
            'category_id' => 1,
            'question' => '',
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'error' => false
            ]);
    }

    /**
     * @test
     * @group api
     */
    public function testStoreCategory()
    {
        $response = $this->postJson('api/v1/category/store', [
            'name' => 'Test Category'
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'error' => false
            ]);
    }


    /**
     * @test
     * @group api
     */
    public function testGetAllCategories()
    {
        $response = $this->get('api/v1/category');
        $response->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    }

    /**
     * @test
     * @group api
     */
    public function testStoreChoice()
    {
        $response = $this->postJson('api/v1/choice/store', [
            'question_id' => 1,
            'description' => 'Choice 1',
            'icon_url' => '',
            'is_correct_choice' => false
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'error' => false
            ]);

    }
}
