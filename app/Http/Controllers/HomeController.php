<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home($value='')
    {
    	return view('auth.login');
    }
    public function YourhomePage($value='')
    {
    	return view('home');
    }
    public function dashboard($value='')
    {
        $nb_voyages = DB::table('voyages')->where('voyages.etat','=',2)->count();

        $nb_reservationvoyages = DB::table('reservationvoyages')->count();

        $nb_clients = DB::table('clients')->count();

        return view('dashboard');
        
    }
}
