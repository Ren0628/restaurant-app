<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        if(Auth::guard('web')->check()) {

            $request->validate([
                'score' => 'required',
                'content' => 'required',
            ]);

            $review = new Review();
            $review->score = $request->input('score');
            $review->content = $request->input('content');
            $review->user_id = Auth::id();
            $review->restaurant_id = $restaurant->id;
            $review->save();

            return redirect()->route('user.show', $restaurant)->with('flash_message', 'レビューを投稿しました。');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review, Restaurant $restaurant)
    {
        if(Auth::guard('web')->check() && Auth::id() === $review->user_id || Auth::guard('admin')->check()) {

            $request->validate([
                'score' => 'required',
                'content' => 'required',
            ]);

            $review->score = $request->input('score');
            $review->content = $request->input('content');
            $review->save();

            if(Auth::guard('web')->check()) {
                return redirect()->route('user.show', $restaurant)->with('flash_message', 'レビューを更新しました。');
            } elseif(Auth::guard('admin')->check()) {
                return redirect()->route('admin.show', $restaurant)->with('flash_message', 'レビューを更新しました。');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review, Restaurant $restaurant)
    {
        if(Auth::guard('web')->check() && Auth::id() === $review->user_id || Auth::guard('admin')->check()) {

            $review->delete();

            
            if(Auth::guard('web')->check()) {
                return redirect()->route('user.show', $restaurant)->with('flash_message', 'レビューを削除しました。');
            } elseif(Auth::guard('admin')->check()) {
                return redirect()->route('admin.show', $restaurant)->with('flash_message', 'レビューを削除しました。');
            }
        }
    }
}
