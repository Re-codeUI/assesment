<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $timeOfDay = $this->getTimeOfDay();
        return view('home', compact('timeOfDay'));
    }
    private function getTimeOfDay(){
        $currentHour = Carbon::now('Asia/Jakarta')->format('H');
        if ($currentHour >= 5 && $currentHour < 12) {
            return 'Pagi';
        } elseif ($currentHour >= 12 && $currentHour < 16) {
            return 'Siang';
        } elseif ($currentHour >= 16 && $currentHour < 19) {
            return 'Sore';
        } else {
            return 'Malam';
        }
    }
}
