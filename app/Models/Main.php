<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;

class Main extends Model
{
    use HasFactory;

    public static function myLocation(): array
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $location = Location::get($ip);
        [$lat, $lon, $cityName] = [$location->latitude,$location->longitude, $location->cityName];
        session(['cityName' => $cityName]);
        return [$lat, $lon, $cityName];
    }

    public static function locationName($name): bool|array
    {
       $response = json_decode(Http::get('http://api.openweathermap.org/geo/1.0/direct?q='.$name.'&limit=1&appid='.config('global.api.apiKey'))->body(), true);
       if ($response){
           session(['cityName' => $name]);
           return ['name' => $response[0]['local_names']['ru'],
                    'lat' => $response[0]['lat'],
                    'lon' => $response[0]['lon']
                    ];
       }else{
           return false;
       }
    }

    public static function weather($lat, $lon, $units, $cityName): bool|array
    {
        $response = json_decode(Http::get('https://api.openweathermap.org/data/3.0/onecall?lat='.$lat.'&lon='.$lon.'&units='.$units.'&lang=ru&appid='.config('global.api.apiKey'))->body(), true);
        if ($response){

            session(['cityName' => $cityName]);

            return [
                'cityName' => $cityName,
                'temp' => $response['current']['temp'],
                'pressure' => $response['current']['pressure'],
                'humidity' => $response['current']['humidity'],
                'wind_speed' => $response['current']['wind_speed'],
                'clouds' => $response['current']['clouds'],
                'description' => $response['current']['weather'][0]['description'],
                'icon' => 'https://openweathermap.org/img/wn/'.$response['current']['weather'][0]['icon'].'.png',
                ];
        }else{
            return false;
        }
    }

    public static function checkbox($checkbox)
    {
        $units = $checkbox ? 'imperial ' : 'metric';
        $locationName = Main::locationName(session('cityName'));
        return Main::weather($locationName['lat'], $locationName['lon'],$units, session('cityName'));
    }

}
