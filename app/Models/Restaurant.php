<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function menus() {
        return $this->hasMany(Menu::class);
    }

    public function location() {
        return $this->hasOne(Location::class);
    }

    // static function get_location($address) {
    //     $myKey = "AIzaSyC1v2WCRaeth7W56X75S0XDwHBK--2g1WA";
    
    //     $encodeAddress = urlencode($address);
        
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey ;
        
    //     $contents= file_get_contents($url);

    //     $jsonData = json_decode($contents,true);

    //     dd($jsonData);
    
    //     return $jsonData["results"][0]["geometry"]["location"];
    // }
}
