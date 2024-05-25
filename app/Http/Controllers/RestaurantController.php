<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Genre;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::all();

        $currentLocation = $request->input('currentLocation');
        if(isset($currentLocation)) {
            $location = Restaurant::get_location($currentLocation);
            $latitude = $location['lat'];
            $longitude = $location['lng'];
        }
        

        $genres = Genre::all();

        $keyword = $request->input('keyword');

        $genre = $request->input('genre');

        if (isset($keyword) || isset($genre)) {
            $serched_restaurants = Restaurant::query()->where('restaurant_name', 'LIKE', "%{$keyword}%")
            ->where('genre', 'LIKE', "%{$genre}%")
            ->get();
        }

        if (isset($currentLocation)) {
            $near_restaurants = Restaurant::select('*')
            ->orderByRaw('ACOS(COS(RADIANS('.$latitude.')) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS('.$longitude.')) + SIN(RADIANS('.$latitude.')) * SIN(RADIANS(lat)))')
            ->get();
        }

        if(isset($serched_restaurants)) {
            return view('restaurants.index', compact('restaurants', 'serched_restaurants', 'genres'));
        } elseif(isset($near_restaurants)) {
            return view('restaurants.index', compact('restaurants', 'near_restaurants', 'genres'));
        } else {
            return view('restaurants.index', compact('restaurants', 'genres'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guard('owner')->check()) {

            $genres = Genre::all();

            return view('restaurants.create', compact('genres'));
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
        if(Auth::guard('owner')->check()) {

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
            $restaurant->owner_id = Auth::id();
            $restaurant->img_path = $path;
            $restaurant->lat = 1;
            $restaurant->lng = 1;
            $restaurant->save();

            return redirect()->route('owner.mypage');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        $menus = $restaurant->menus;

        return view('restaurants.show', compact('restaurant', 'menus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id || Auth::guard('admin')->check()) {

            $genres = Genre::all();

            return view('restaurants.edit', compact('restaurant', 'genres'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id || Auth::guard('admin')->check()) {

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
            $restaurant->lat = 1;
            $restaurant->lng = 1;
            $restaurant->save();

            if(Auth::guard('owner')->check()) {
                return redirect()->route('owner.mypage');
            } elseif(Auth::guard('admin')->check()) {
                return redirect()->route('admin-home');
            }
        }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id || Auth::guard('admin')->check()) {

            Storage::disk('public')->delete($restaurant->img_path);
            $restaurant->delete();

            if(Auth::guard('owner')->check()) {
                return redirect()->route('owner.mypage');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin-home');
            }
        }
    }

    public function showOwnerMypage(Request $request)
    {
        if(Auth::guard('owner')->check()) {

            $restaurants = Auth::user()->restaurants;

            $genres = Genre::all();

            $currentLocation = $request->input('currentLocation');
            if(isset($currentLocation)) {
                $location = Restaurant::get_location($currentLocation);
                $latitude = $location['lat'];
                $longitude = $location['lng'];
            }
            
            $keyword = $request->input('keyword');

            $genre = $request->input('genre');

            if (isset($keyword) || isset($genre)) {
                $serched_restaurants = Restaurant::query()->where('owner_id', Auth::id())
                ->where('restaurant_name', 'LIKE', "%{$keyword}%")
                ->where('genre', 'LIKE', "%{$genre}%")
                ->get();
            }

            if (isset($currentLocation)) {
                $near_restaurants = Restaurant::select('*')
                ->where('owner_id', Auth::id())
                ->orderByRaw('ACOS(COS(RADIANS('.$latitude.')) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS('.$longitude.')) + SIN(RADIANS('.$latitude.')) * SIN(RADIANS(lat)))')
                ->get();
            }
            
            if(isset($serched_restaurants)) {
                return view('restaurants.index', compact('restaurants', 'serched_restaurants', 'genres'));
            } elseif(isset($near_restaurants)) {
                return view('restaurants.index', compact('restaurants', 'near_restaurants', 'genres'));
            } else {
                return view('restaurants.index', compact('restaurants', 'genres'));
            }
        }
    }

    public function showUserMypage(Request $request)
    {
        if(Auth::guard('web')->check()) {
    
            $restaurants = Auth::user()->restaurants;

            $genres = Genre::all();

            $currentLocation = $request->input('currentLocation');
            if(isset($currentLocation)) {
                $location = Restaurant::get_location($currentLocation);
                $latitude = $location['lat'];
                $longitude = $location['lng'];
            }

            $keyword = $request->input('keyword');

            $genre = $request->input('genre');

            if (isset($keyword) || isset($genre)) {
                $serched_restaurants = Restaurant::query()->whereHas('users', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->where('restaurant_name', 'LIKE', "%{$keyword}%")
                ->where('genre', 'LIKE', "%{$genre}%")
                ->get();
            }

            if (isset($currentLocation)) {
                $near_restaurants = Restaurant::select('*', 'restaurants.id as id')
                ->join('restaurant_user', 'restaurants.id', '=', 'restaurant_user.restaurant_id')
                ->where('user_id', Auth::id())
                ->orderByRaw('ACOS(COS(RADIANS('.$latitude.')) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS('.$longitude.')) + SIN(RADIANS('.$latitude.')) * SIN(RADIANS(lat)))')
                ->get();
            }
            
            if(isset($serched_restaurants)) {
                return view('restaurants.index', compact('restaurants', 'serched_restaurants', 'genres'));
            } elseif(isset($near_restaurants)) {
                return view('restaurants.index', compact('restaurants', 'near_restaurants', 'genres'));
            } else {
                return view('restaurants.index', compact('restaurants', 'genres'));
            }
        }
    }

    public function bookmark(Restaurant $restaurant) {

        if(Auth::guard('web')->check()) {

            if(!Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) {
                $restaurant->users()->attach(Auth::id());
            } elseif(Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists()) {
                $restaurant->users()->detach(Auth::id());
            }
            
            return back();
        }
    }
}
