<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class GenreController extends Controller
{

    public function index(): Collection
    {
        return Genre::all();
    }

    public function store(GenreRequest $request): Genre
    {
        $request->validated();
        $genre = new Genre();
        return Genre::create($request->only($genre->getWritable()));
    }

    public function show(Genre $genre): Genre
    {
        return $genre;
    }

    public function update(GenreRequest $request, Genre $genre): Genre
    {
        $request->validated();
        $genre->update($request->only($genre->getWritable()));
        return $genre;
    }

    public function destroy(Genre $genre): Response
    {
        $genre->delete();
        return response()->noContent();
    }
}
