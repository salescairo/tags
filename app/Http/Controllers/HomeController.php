<?php

namespace App\Http\Controllers;

use App\Charts\KidsPieChart;
use App\Repository\Contract\KidInterface;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(KidsPieChart $kidsPieChart,KidInterface $kidInterface)
    {
        return view('home',[
            'kidsPieChart'=>$kidsPieChart->build(),
            'kidsAllNumber'=>$kidInterface->total()
        ]);
    }
}
