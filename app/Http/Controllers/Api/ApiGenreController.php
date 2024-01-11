<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;


class ApiGenreController extends Controller
{

    public function index()
    {
        $genres = Genre::all();
        return response()->json([
            'genres' => $genres,
        ]);
    }

    
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'genre' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'ジャンルを入力してください。',
            ]);
        }

        $genre = new Genre();
        $genre->genre = $request->input('genre');
        $genre->save();

        $message = '「'.$request->input('genre').'」'.'を追加しました。';

        $genres = Genre::all();

        return response()->json([
            'genres' => $genres,
            'message' => $message,
            'status' => 200,
        ]);
    }

    
    public function update(Request $request, Genre $genre)
    {
        $validator = Validator::make($request->all(), [
            'genre' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'ジャンルを入力してください。',
            ]);
        }

        $message = '「'.$genre->genre.'」を'.'「'.$request->input('genre').'」'.'へ更新しました。';

        $genre->genre = $request->input('genre');
        $genre->save();

        $genres = Genre::all();

        return response()->json([
            'genres' => $genres,
            'message' => $message,
            'status' => 200,
        ]);
    }

    
    public function destroy(Genre $genre)
    {
        $genre->delete();

        $message = '「'.$genre->genre.'」'.'を削除しました。';

        $genres = Genre::all();

        return response()->json([
            'genres' => $genres,
            'message' => $message,
        ]);
    }
}
