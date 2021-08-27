<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $genre = Genre::factory()->create();
        $response = $this->get(route('genres.index'));
        $response->assertStatus(200)->assertJson([$genre->toArray()]);
    }

    public function testShow()
    {
        $genre = Genre::factory()->create();
        $response = $this->get(route('genres.show', ['genre' => $genre->id]));
        $response->assertStatus(200)->assertJson($genre->toArray());
    }

    public function testStoreInvalidationData()
    {
        $response = $this->json('POST', route('genres.store'), []);
        $this->assertInvalidationRequired($response);

        $response = $this->json(
            'POST',
            route('genres.store'),
            [
                'name' => str_repeat('a', 256),
                'is_active' => 'a'
            ]
        );
        $this->assertInvalidationMaxName($response)->assertInvalidationTypeIsActive($response);
    }

    public function testUpdateInvalidationData()
    {
        /** @var Genre $genre */
        $genre = Genre::factory()->create();

        $response = $this->json('PUT', route('genres.update', ['genre' => $genre->id]), []);
        $this->assertInvalidationRequired($response);

        $response = $this->json(
            'PUT',
            route('genres.update', ['genre' => $genre->id]),
            [
                'name' => str_repeat('a', 256),
                'is_active' => 'a'
            ]
        );
        $this->assertInvalidationMaxName($response)->assertInvalidationTypeIsActive($response);
    }

    private function assertInvalidationRequired(TestResponse $response): GenreControllerTest
    {
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonFragment([\Lang::get('validation.required', ['attribute' => 'name'])]);
        return $this;
    }

    private function assertInvalidationMaxName(TestResponse $response): GenreControllerTest
    {
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([\Lang::get('validation.max.string', ['attribute' => 'name', 'max' => 255])]);
        return $this;
    }

    private function assertInvalidationTypeIsActive(TestResponse $response): GenreControllerTest
    {
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['is_active'])
            ->assertJsonFragment([\Lang::get('validation.boolean', ['attribute' => 'is active'])]);
        return $this;
    }
}
