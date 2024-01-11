<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiRestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('users:id')->get();

        return response()->json([
            'restaurants' => $restaurants,
        ], 200);
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'required',
            'introduction' => 'required',
            'genre' => 'required',
            'budget' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'access' => 'required',
            'img_path' => 'required',
        ]);

        $path = $request->file('img_path')->store('img', 'public');

        $restaurant = new Restaurant();
        $restaurant->restaurant_name = $request->input('restaurant_name');
        $restaurant->introduction = $request->input('introduction');
        $restaurant->genre = $request->input('genre');
        $restaurant->budget = $request->input('budget');
        $restaurant->phone = $request->input('phone');
        $restaurant->address = $request->input('address');
        $restaurant->access = $request->input('access');
        $restaurant->owner_id = Auth::guard('owner')->id();
        $restaurant->img_path = $path;
        $restaurant->lat = Restaurant::get_location($restaurant->address)['lat'];
        $restaurant->lng = Restaurant::get_location($restaurant->address)['lng'];
        $restaurant->save();

        $message = '「'.$restaurant->restaurant_name.'」'.'を登録しました。';

        $restaurants = Restaurant::with('users:id')->get();

        return response()->json([
            'message' => $message,
            'restaurants' => $restaurants,
        ], 200);

    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'restaurant_name' => 'required',
            'introduction' => 'required',
            'genre' => 'required',
            'budget' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'access' => 'required',
            'img_path' => 'required',
        ]);

        Storage::disk('public')->delete($restaurant->img_path);

        $path = $request->file('img_path')->store('img', 'public');

        $restaurant->restaurant_name = $request->input('restaurant_name');
        $restaurant->introduction = $request->input('introduction');
        $restaurant->genre = $request->input('genre');
        $restaurant->budget = $request->input('budget');
        $restaurant->phone = $request->input('phone');
        $restaurant->address = $request->input('address');
        $restaurant->access = $request->input('access');
        $restaurant->img_path = $path;
        $restaurant->lat = Restaurant::get_location($restaurant->address)['lat'];
        $restaurant->lng = Restaurant::get_location($restaurant->address)['lng'];
        $restaurant->save();

        $message = '「'.$restaurant->restaurant_name.'」'.'を更新しました。';

        $restaurants = Restaurant::with('users:id')->get();

        return response()->json([
            'message' => $message,
            'restaurants' => $restaurants,
        ], 200);
    }
    
    public function destroy(Restaurant $restaurant)
    {
        Storage::disk('public')->delete($restaurant->img_path);
        $restaurant->delete();

        $message = '「'.$restaurant->restaurant_name.'」'.'を削除しました。';

        $restaurants = Restaurant::with('users:id')->get();

        return response()->json([
            'message' => $message,
            'restaurants' => $restaurants,
        ], 200);
    }

    public function searchRestaurants(Request $request)
    {
        $keyword = $request->input('keyword');
        $genre = $request->input('genre');

        $searched_restaurants = Restaurant::query()
        ->where('restaurant_name', 'LIKE', "%{$keyword}%")
        ->where('genre', 'LIKE', "%{$genre}%")
        ->with('users:id')
        ->get();

        return response()->json([
            'restaurants' => $searched_restaurants,
        ], 200);
    }

    public function nearbyRestaurants(Request $request)
    {
        $currentLocation = $request->input('currentLocation');

        $location = Restaurant::get_location($currentLocation);
        $latitude = $location['lat'];
        $longitude = $location['lng'];

        $near_restaurants = Restaurant::select('*')
        ->orderByRaw('ACOS(COS(RADIANS('.$latitude.')) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS('.$longitude.')) + SIN(RADIANS('.$latitude.')) * SIN(RADIANS(lat)))')
        ->with('users:id')
        ->get();

        return response()->json([
            'restaurants' => $near_restaurants,
        ], 200);
    }
}
