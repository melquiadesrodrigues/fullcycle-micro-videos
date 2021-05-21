<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function textIndex()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200)->assertJson([$category->toArray()]);
    }

    public function textShow()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', ['category' => $category->id]));
        $response->assertStatus(200)->assertJson($category->toArray());
    }

    public function testStoreInvalidationData()
    {
        $response = $this->json('POST', route('categories.store'), []);
        $this->assertInvalidationRequired($response);

        $response = $this->json('POST', route('categories.store'), [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]);
        $this->assertInvalidationMaxName($response)->assertInvalidationTypeIsActive($response);
    }

    public function testUpdateInvalidationData()
    {
        /** @var Category $category */
        $category = Category::factory()->create();

        $response = $this->json('PUT', route('categories.update', ['category' => $category->id]), []);
        $this->assertInvalidationRequired($response);

        $response = $this->json('PUT', route('categories.update', ['category' => $category->id]), [
            'name' => str_repeat('a', 256),
            'is_active' => 'a'
        ]);
        $this->assertInvalidationMaxName($response)->assertInvalidationTypeIsActive($response);
    }

    private function assertInvalidationRequired(TestResponse $response): CategoryControllerTest
    {
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name'])
                 ->assertJsonMissingValidationErrors(['is_active'])
                 ->assertJsonFragment([\Lang::get('validation.required', ['attribute' => 'name'])]);
        return $this;
    }

    private function assertInvalidationMaxName(TestResponse $response): CategoryControllerTest
    {
        $response->assertStatus(422)->assertJsonValidationErrors(['name'])->assertJsonFragment([
            \Lang::get('validation.max.string', ['attribute' => 'name', 'max' => 255])
        ]);
        return $this;
    }

    private function assertInvalidationTypeIsActive(TestResponse $response): CategoryControllerTest
    {
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['is_active'])
                 ->assertJsonFragment([\Lang::get('validation.boolean', ['attribute' => 'is active'])]);
        return $this;
    }
}
