<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use App\Models\Traits\Writable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes, HasFactory, Writable, Uuid;

    protected $fillable = ['name', 'is_active'];
    protected $dates = ['deleted_at'];
    protected $casts = ['id' => 'string'];
    public $incrementing = false;
}
