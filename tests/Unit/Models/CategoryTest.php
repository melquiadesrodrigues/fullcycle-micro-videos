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
        $this->assertEqualsCanonicalizing($expectedFillables, $this->category->getFillable());
    }

    public function testCastsAttribute()
    {
        $expectedCasts = ['id' => 'string', 'deleted_at' => 'datetime', 'is_active' => 'boolean'];
        $this->assertEqualsCanonicalizing($expectedCasts, $this->category->getCasts());
    }

    public function testDatesAttribute()
    {
        $expectedDates = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertEqualsCanonicalizing($expectedDates, $this->category->getDates());
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
        $this->assertEqualsCanonicalizing($expectedTraits, $categoryTraits);
    }

}
