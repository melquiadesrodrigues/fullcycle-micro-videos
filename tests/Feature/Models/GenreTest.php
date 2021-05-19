<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;
    
    private Genre $genre;

    public function testList()
    {
        Genre::factory(1)->create();
        $categories = Genre::all();
        $this->assertCount(1, $categories);
        $genreKeys = array_keys($categories->first()->getAttributes());
        $expectedKeys = ['id', 'name', 'is_active', 'created_at', 'updated_at', 'deleted_at'];
        $this->assertEqualsCanonicalizing($expectedKeys, $genreKeys);
    }

    public function testCreate()
    {
        $genre = Genre::create(['name' => 'test'])->refresh();
        $this->assertTrue(Uuid::isValid($genre->id));
        $this->assertEquals('test', $genre->name);
        $this->assertTrue($genre->is_active);
        
        $genre = Genre::create(['name' => 'test', 'is_active' => false])->refresh();
        $this->assertFalse($genre->is_active);
        
        $genre = Genre::create(['name' => 'test', 'is_active' => true])->refresh();
        $this->assertTrue($genre->is_active);
    }
    
    public function testUpdate()
    {
        $genre = Genre::factory()->create(['is_active' => false]);
        $data = ['name' => 'test_name_updated', 'is_active' => true];
        $genre->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }
    
    public function testDelete()
    {
        /** @var Genre $genre */
        $genre = Genre::factory()->create();
        $id = $genre->id;
        $genre->delete();
        $this->assertNull(Genre::find($id));
        $trashed = Genre::onlyTrashed()->find($id);
        $this->assertInstanceOf(Genre::class, $trashed);
        $this->assertNotNull($trashed->deleted_at);
    }

}
