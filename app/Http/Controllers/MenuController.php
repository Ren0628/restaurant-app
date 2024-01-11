<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        if(Auth::guard('owner')->check() && Auth::guard('owner')->id() === $restaurant->owner_id || Auth::guard('admin')->check()) {

            $request->validate([
                'menu_name' => 'required',
                'price' => 'required',
            ]);

            $menu = new Menu();

            $menu->menu_name = $request->input('menu_name');
            $menu->price = $request->input('price');
            $menu->restaurant_id = $restaurant->id;
            $menu->save();

            return back()->with('flash_message', 'メニューを追加しました。');
        } else {
            var_dump(Auth::id());
            var_dump($restaurant->owner_id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if(Auth::guard('owner')->check() && Auth::id() === $menu->restaurant->owner_id || Auth::guard('admin')->check()) {

            $request->validate([
                'menu_name' => 'required',
                'price' => 'required',
            ]);

            $menu->menu_name = $request->input('menu_name');
            $menu->price = $request->input('price');
            $menu->save();

            return back()->with('flash_message', 'メニューを編集しました。');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if(Auth::guard('owner')->check() && Auth::id() === $menu->restaurant->owner_id || Auth::guard('admin')->check()) {

            $menu->delete();

            return back()->with('flash_message', 'メニューを削除しました。');
        }
    }
}
