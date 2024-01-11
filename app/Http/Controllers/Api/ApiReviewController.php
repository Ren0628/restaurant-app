<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user:id,name')->get();

        return response()->json([
            'reviews' => $reviews,
        ], 200);
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required',
            'content' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $review = new Review();
        $review->score = $request->input('score');
        $review->content = $request->input('content');
        $review->user_id = Auth::id();
        $review->restaurant_id = $restaurant->id;
        $review->save();

        $reviews = Review::with('user:id,name')->get();

        $message = "レビューを投稿しました。";

        return response()->json([
            'reviews' => $reviews,
            'message' => $message,
            'status' => 200,
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required',
            'content' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $review->score = $request->input('score');
        $review->content = $request->input('content');
        $review->save();

        $reviews = Review::with('user:id,name')->get();

        $message = "レビューを更新しました。";

        return response()->json([
            'reviews' => $reviews,
            'message' => $message,
            'status' => 200,
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        $reviews = Review::with('user:id,name')->get();

        $message = "レビューを削除しました。";

        return response()->json([
            'reviews' => $reviews,
            'message' => $message,
        ], 200);
    }
}