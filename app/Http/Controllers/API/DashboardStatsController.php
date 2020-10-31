<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Sentinel;
use App\Partenaire;


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
        $nb_voyages = DB::table('voyages')->count();
        return response()->json($nb_voyages);
    }

    public function voyagesPartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $nb_voyages_partenaire = DB::table('voyages')->where('voyages.partenaire','=',$partenaire->id)
        ->count();

        return response()->json($nb_voyages_partenaire);
    }

    public function reservations()
    {
        $nb_reservationvoyages = DB::table('reservationvoyages')->count();
        return response()->json($nb_reservationvoyages);
    }
//pas bon
    public function reservationsPartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $nb_reservationvoyages = DB::table('reservationvoyages')
        ->join('voyages','voyages.id','=','reservationvoyages.voyage')
        ->where('voyages.partenaire','=',$partenaire->id)
        ->count();

        return response()->json($nb_reservationvoyages_partenaire);
    }

    public function reservationsConfirmes()
    {
        $nb_reservationvoyages_confirmes = DB::table('reservationvoyages')
        ->where('reservationvoyages.statut','=',2)->count();
        return response()->json($nb_reservationvoyages_confirmes);
    }

    public function reservationsConfirmesPartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $nb_reservationvoyages_confirmes_partenaire = DB::table('reservationvoyages')
        ->join('voyages','voyages.id','=','reservationvoyages.voyage')
        ->where('voyages.partenaire','=',$partenaire->id)
        ->where('reservationvoyages.statut','=',2)
        ->count();

        return response()->json($nb_reservationvoyages_confirmes_partenaire);
    }

    public function reservationsAnnules()
    {
        $nb_reservationvoyages_annules = DB::table('reservationvoyages'
        )->where('reservationvoyages.statut','=',1)->count();
        return response()->json($nb_reservationvoyages_annules);
    }

    public function reservationsAnnulesPartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $nb_reservationvoyages_annules_partenaire = DB::table('reservationvoyages')
        ->join('voyages','voyages.id','=','reservationvoyages.voyage')
        ->where('voyages.partenaire','=',$partenaire->id)
        ->where('reservationvoyages.statut','=',1)
        ->count();

        return response()->json($nb_reservationvoyages_annules_partenaire);
    }

    public function clients()
    {
        $nb_clients = DB::table('clients')->count();
        return response()->json($nb_clients);
    }


    public function locations()
    {
        $nb_locations = DB::table('locations')->count();
        return response()->json($nb_locations);
    }

    public function locationsPartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $nb_locations_partenaire = DB::table('locations')
        ->where('locations.partenaire','=',$partenaire->id)
        ->count();

        return response()->json($nb_locations_partenaire);
    }

    public function recettesVoyages()
    {
        $recettes = DB::table('reservationvoyages')
        ->where('reservationvoyages.statut','=',2)
        ->sum('reservationvoyages.prix_voyage'); 
        return response()->json($recettes);
    }

    public function recettesVoyagespartenaire()
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        $recettes_partenaire = DB::table('reservationvoyages')
        ->where([
            ['reservationvoyages.statut','=',2],
            ['reservationvoyages.partenaire','=',$partenaire->id]
          ])
        ->sum('reservationvoyages.prix_voyage'); 

        return response()->json($recettes_partenaire);
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
