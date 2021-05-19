<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use App\Models\Traits\Writable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testFillableAttribute()
    {
        $expectedFillables = ['name', 'description', 'is_active'];
        foreach ($expectedFillables as $expectedFillable) {
            $this->assertContains($expectedFillable, $this->category->getFillable());
        }
        $this->assertCount(count($expectedFillables), $this->category->getFillable());
    }

    public function testCastsAttribute()
    {
        $expectedCasts = ['id' => 'string', 'deleted_at' => 'datetime'];
        foreach ($expectedCasts as $expectedCast) {
            $this->assertContains($expectedCast, $this->category->getCasts());
        }
        $this->assertCount(count($expectedCasts), $this->category->getCasts());
    }

    public function testDatesAttribute()
    {
        $expectedDates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($expectedDates as $expectedDate) {
            $this->assertContains($expectedDate, $this->category->getDates());
        }
        $this->assertCount(count($expectedDates), $this->category->getDates());
    }

    public function testIncrementingAttribute()
    {
        $expectedIncrementing = false;
        $this->assertEquals($expectedIncrementing, $this->category->getIncrementing());
    }

    public function testIfUseTraits()
    {
        $expectedTraits = [SoftDeletes::class, HasFactory::class, Uuid::class, Writable::class];
        $categoryTraits = class_uses(Category::class);
        foreach ($expectedTraits as $expectedTrait) {
            $this->assertContains($expectedTrait, $categoryTraits);
        }
        $this->assertCount(count($expectedTraits), $categoryTraits);
    }

}
