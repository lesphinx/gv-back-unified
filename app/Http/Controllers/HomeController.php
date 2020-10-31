<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;



class HomeController extends Controller
{
    public function home($value='')
    {
        //return view('auth.login');
        return view('welcome');

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

        $user=Sentinel::getUser();

        //dd($partenaire);

        if($user->inRole('admin') || $user->inRole('super-admin'))

        {
            return view('dashboard');
        }
        else if($user->inRole('partenaire') || $user->inRole('Partenaire'))
        {
            return view('dashboardPartenaire');
        }
        else
        {

        }

        
    }


    public function dashboardPartenaire($value='')
    {
        $nb_voyages = DB::table('voyages')->where('voyages.etat','=',2)->count();

        $nb_reservationvoyages = DB::table('reservationvoyages')->count();

        $nb_clients = DB::table('clients')->count();

        return view('dashboardPartenaire');
        
    }
}
