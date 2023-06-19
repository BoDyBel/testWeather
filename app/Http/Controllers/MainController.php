<?php

namespace App\Http\Controllers;

use App\Models\Main;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class MainController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        [$lat, $lon, $cityName] = Main::myLocation();
        $weather = Main::weather($lat, $lon,'metric', $cityName);
        return view('layouts.index', compact('cityName','weather'));
    }

    public function locationName(Request $request)
    {
        $locationName = Main::locationName($request->cityName);
        if ($locationName){
            $weather = Main::weather($locationName['lat'], $locationName['lon'],'metric', $request->cityName);
            return view('layouts.index', compact('weather'));
        }else{
            return to_route('index')->withMessage('Город с таким названием "'.$request->cityName.'"  не найден.');
        }
    }

    public function checkbox(Request $request)
    {
        $weather = Main::checkbox($request->checkbox);
        if ($weather){
            if ($request->checkbox){
                $checked = true;
                return view('layouts.index', compact('weather', 'checked'));
            }else{
                return view('layouts.index', compact('weather',));
            }

        }
        return to_route('index')->withMessage('Произошла ошибка');
    }
}
