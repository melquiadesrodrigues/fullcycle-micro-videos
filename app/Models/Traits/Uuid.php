<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

trait Uuid
{
    public static function find($id, $columns = ['*'])
    {
        $strId = strval($id);
        return static::query()->find($strId, $columns);
    }

    protected static function bootUuid()
    {
        static::creating(
            function (Model $obj) {
                $obj->{$obj->getKeyName()} = RamseyUuid::uuid4()->toString();
            }
        );
    }
}