<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use App\Models\Traits\Writable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class GenreTest extends TestCase
{
    private Genre $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testFillableAttribute()
    {
        $expectedFillables = ['name', 'is_active'];
        $this->assertEqualsCanonicalizing($expectedFillables, $this->genre->getFillable());
    }

    public function testCastsAttribute()
    {
        $expectedCasts = ['id' => 'string', 'deleted_at' => 'datetime', 'is_active' => 'boolean'];
        $this->assertEqualsCanonicalizing($expectedCasts, $this->genre->getCasts());
    }

    public function testDatesAttribute()
    {
        $expectedDates = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertEqualsCanonicalizing($expectedDates, $this->genre->getDates());
    }

    public function testIncrementingAttribute()
    {
        $expectedIncrementing = false;
        $this->assertEquals($expectedIncrementing, $this->genre->getIncrementing());
    }

    public function testIfUseTraits()
    {
        $expectedTraits = [SoftDeletes::class, HasFactory::class, Uuid::class, Writable::class];
        $genreTraits = class_uses(Genre::class);
        $this->assertEqualsCanonicalizing($expectedTraits, $genreTraits);
    }

}
