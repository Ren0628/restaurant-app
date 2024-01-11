<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    static function get_location($address) {
        $myKey = "AIzaSyC1v2WCRaeth7W56X75S0XDwHBK--2g1WA";
    
        $encodeAddress = urlencode($address);
    
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey ;
    
        $contents= file_get_contents($url);
        $jsonData = json_decode($contents,true);
    
        return $jsonData["results"][0]["geometry"]["location"];
    }
}
