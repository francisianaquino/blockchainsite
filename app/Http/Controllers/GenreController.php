<?php

namespace App\Http\Controllers;
use App\Genre;

use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index() {
        $genre = Genre::orderBy('genre', 'asc')->get();
        return view('genre.index', [
            'genre' => $genre
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'genre' => 'required|string|unique:genres'
        ]);

        $data = $request->all();
        $data['genre'] = strtolower($data['genre']);

        Genre::create($data);
        return back()->with('success', 'Genre Added');
    }

    public function destroy($id) {
        $genre = Genre::find($id);
        $genre->delete();

        return back()->with('success', 'Genre Deleted');
    }
}
