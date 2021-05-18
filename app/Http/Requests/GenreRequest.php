<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class GenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    #[ArrayShape(['name' => "string", 'is_active' => "string"])] public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'is_active' => 'boolean'
        ];
    }
}
