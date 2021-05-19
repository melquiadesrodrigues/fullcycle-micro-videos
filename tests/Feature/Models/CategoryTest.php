<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    
    private Category $category;

    public function testList()
    {
        Category::factory(1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKeys = array_keys($categories->first()->getAttributes());
        $expectedKeys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at', 'deleted_at'];
        $this->assertEqualsCanonicalizing($expectedKeys, $categoryKeys);
    }

    public function testCreate()
    {
        $category = Category::create(['name' => 'test'])->refresh();
        $this->assertTrue(Uuid::isValid($category->id));
        $this->assertEquals('test', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
        
        $category = Category::create(['name' => 'test', 'description' => null])->refresh();
        $this->assertNull($category->description);
        
        $category = Category::create(['name' => 'test', 'description' => 'description3'])->refresh();
        $this->assertEquals('description3', $category->description);
        
        $category = Category::create(['name' => 'test', 'is_active' => false])->refresh();
        $this->assertFalse($category->is_active);
        
        $category = Category::create(['name' => 'test', 'is_active' => true])->refresh();
        $this->assertTrue($category->is_active);
    }
    
    public function testUpdate()
    {
        $category = Category::factory()->create(['is_active' => false]);
        $data = ['name' => 'test_name_updated', 'description' => 'test_description_updated', 'is_active' => true];
        $category->update($data);
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }
    
    public function testDelete()
    {
        /** @var Category $category */
        $category = Category::factory()->create();
        $id = $category->id;
        $category->delete();
        $this->assertNull(Category::find($id));
        $trashed = Category::onlyTrashed()->find($id);
        $this->assertInstanceOf(Category::class, $trashed);
        $this->assertNotNull($trashed->deleted_at);
    }

}
