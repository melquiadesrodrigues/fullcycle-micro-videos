<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Schema;

trait Writable
{
    public function getWritable(): array
    {
        if (!empty($this->fillable))
            return $this->fillable;

        return collect(Schema::getColumnListing($this->getTable()))
            ->flip()
            ->except($this->guarded)
            ->keys()
            ->toArray();
    }
}