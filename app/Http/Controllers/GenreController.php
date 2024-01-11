<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{

    public function index() {
        if(Auth::guard('admin')->check()) {

            $genres = Genre::all();
            return view('genres.index', compact('genres'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('admin')->check()) {

            $request->validate([
                'genre' => 'required',
            ]);

            $genre = new Genre();
            $genre->genre = $request->input('genre');
            $genre->save();

            return back()->with('flash_message', 'ジャンルを追加しました。');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        if(Auth::guard('admin')->check()) {

            $request->validate([
                'genre' => 'required',
            ]);

            $genre->genre = $request->input('genre');
            $genre->save();

            return back()->with('flash_message', 'ジャンルを編集しました。');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        if(Auth::guard('admin')->check()) {
            
            $genre->delete();

            return back()->with('flash_message', 'ジャンルを削除しました。');
        }
    }
}
