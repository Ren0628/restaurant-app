<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiMenuController extends Controller
{

    public function index()
    {
        $menus = Menu::all();

        return response()->json([
            'menus' => $menus,
        ], 200);
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $menu = new Menu();

        $menu->menu_name = $request->input('menu_name');
        $menu->price = $request->input('price');
        $menu->restaurant_id = $restaurant->id;
        $menu->save();

        $message = 'メニュー「'.$request->input('menu_name').'」'.'を追加しました。';

        $menus = Menu::all();

        return response()->json([
            'menus' => $menus,
            'message' => $message,
            'status' => 200,
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ]);
        }

        $message = 'メニュー「'.$menu->menu_name.'」を'.'「'.$request->input('menu_name').'」へ更新しました。';

        $menu->menu_name = $request->input('menu_name');
        $menu->price = $request->input('price');
        $menu->save();

        $menus = Menu::all();

        return response()->json([
            'menus' => $menus,
            'message' => $message,
            'status' => 200,
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        $message = 'メニュー「'.$menu->menu_name.'」'.'を削除しました。';

        $menus = Menu::all();

        return response()->json([
            'menus' => $menus,
            'message' => $message,
        ], 200);
    }
}