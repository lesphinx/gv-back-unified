<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    public function voyagesClientParJour()
    {
        $nb_voyage_client = DB::table('reservationvoyages')
       /* ->join('voyages','reservationvoyages.voyage','=','voyages.id')
        ->join('clients','reservationvoyages.client','=','clients.id')
        ->where('reservationvoyages.statut','=',2)
        ->whereDate('reservationvoyages.dateVoyage',d('Y-m-d'))*/
        ->get();
        
        return response()->json($nb_voyage_client);

    }

    public function voyages()
    {
        $nb_voyages = DB::table('voyages')->where('voyages.etat','=',2)->get()->count();
        return response()->json($nb_voyages);
    }

    public function reservations()
    {
        $nb_reservationvoyages = DB::table('reservationvoyages')->count();
        return response()->json($nb_reservationvoyages);
    }

    public function reservationsConfirmes()
    {
        $nb_reservationvoyages_confirmes = DB::table('reservationvoyages')->where('reservationvoyages.statut','=',2)->count();
        return response()->json($nb_reservationvoyages_confirmes);
    }

    public function reservationsAnnules()
    {
        $nb_reservationvoyages_annules = DB::table('reservationvoyages')->where('reservationvoyages.statut','=',1)->count();
        return response()->json($nb_reservationvoyages_annules);
    }

    public function clients()
    {
        $nb_clients = DB::table('clients')->count();
        return response()->json($nb_clients);
    }

    public function locations()
    {
        $nb_locations = DB::table('reservationlocations')->count();
        return response()->json($nb_locations);
    }

    public function recettesVoyages()
    {
        $recettes = DB::table('reservationvoyages')->where('reservationvoyages.statut','=',2)->sum('reservationvoyages.prix_voyage'); 
        return response()->json($recettes);
    }

    public function reservationsByAnnee($mois)
    {
        $voyagesByMois = DB::table('reservationvoyages')
            ->where('reservationvoyages.statut','=','2')
            ->whereMonth('reservationvoyages.date_validation', '=', $mois)
            ->whereYear('reservationvoyages.date_validation', '=', date('Y'))
            ->count();
            
        return response()->json($voyagesByMois);
    }


    public function locationsByAnnee($mois)
    {
        $locationsByMois = DB::table('reservationlocations')
            ->where('reservationlocations.statut','=','2')
            ->whereMonth('reservationlocations.date_validation', '=', $mois)
            ->whereYear('reservationlocations.date_validation', '=', date('Y'))
            ->count(); 
        return response()->json($locationsByMois);
    }

}
