<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiBookmarkController extends Controller
{

    public function isBookmark(Restaurant $restaurant)
    {
        if(!Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) 
        {
            return response()->json([
                'isBookmark' => false,
            ], 200);

        } elseif(Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) {

            return response()->json([
                'isBookmark' => true,
            ], 200);

        } else {
            return;
        }
    }

    public function bookmark(Restaurant $restaurant) {

            if(!Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) {

                $restaurant->users()->attach(Auth::id());

                $restaurants = Restaurant::with('users:id')->get();

                return response()->json([
                    'isBookmark' => true,
                    'message' => 'お気に入り登録しました。',
                    'restaurants' => $restaurants,
                ], 200);

            } elseif(Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) {

                $restaurant->users()->detach(Auth::id());

                $restaurants = Restaurant::with('users:id')->get();

                return response()->json([
                    'isBookmark' => false,
                    'message' => 'お気に入り登録を解除しました。',
                    'restaurants' => $restaurants,
                ], 200);
            }
    }

}