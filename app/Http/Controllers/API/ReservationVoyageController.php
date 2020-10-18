<?php

namespace App\Http\Controllers\API;
use App\Billet;
use App\Classe;
use App\Http\Controllers\Controller;

use App\Http\Resources\ReservationVoyage as ReservationVoyageResource;
use App\Itineraire;
use App\Partenaire;
use App\ReservationVoyage;
use App\TypePiece;
use App\Voyage;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

setlocale (LC_TIME, 'fr_FR.utf8','fra');
/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ReservationVoyageController
|
|
|
|*/


class ReservationVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ReservationVoyageResource::collection(ReservationVoyage::paginate(10))->isEmpty()){
                   fetchLog(ReservationVoyage::class);
                    return response()->json(['content'=>ReservationVoyage::orderBy('created_at','desc')->paginate(10),'message'=>'liste des ReservationVoyages'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(ReservationVoyage::class);
                return response()->json(['message'=>'ReservationVoyages empty']);

    }


    public function all_type_pieces() {
        $types = TypePiece::all();
        return response()->json($types);
    }

    /**
     * La liste des reservations pour un client.
     *
     * @return Response
     */

    public function reservation_for_user($id_user)
    {
        $voyages = ReservationVoyageResource::collection(
            ReservationVoyage::orderBy('created_at','desc')
                             ->where('client', '=' , $id_user)->get());
        return response()->json([
            'content'=> $voyages,
            'message'=>'liste des ReservationVoyages'],
            200,['Content-Type'=>'application/json']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $now = new \DateTime();
        $voyage = $request->voyage;
        $client = $request->client;

        foreach ($request->users as $usr) {
            $data = [
                'date_reservation' => $now->format('Y-m-d H:i:s'),
                'statut' => 1,
                'nom_voyageur' =>$usr['nom'],
                'prenom_voyageur' =>$usr['prenom'],
                'client' => $client,
                'classe' =>$usr['classe'],
                'voyage' =>$voyage,
                'numero_piece' => $usr['numeroPiece'],
                'age_voyageur' =>$usr['age'],
                'type_piece' => $usr['typePiece'],
                'slug' => str_randomize(20),
                'age_voyageur' => $usr['age'],
                'prix_voyage' => $usr['prix_voyage']
            ];
            ReservationVoyage::create($data);
            // Il faut penser à décrement le nombre de place après uen resevation
            $voy = Voyage::where('id' , '=' , $voyage)->first();
            $voy->nombre_place = $voy->nombre_place - 1;
            $voy->save();

        }

       createFailureLog( ReservationVoyage::class);
       return response()->json(['message'=>'echec de création ReservationVoyage']);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function show(Request $request,$slug)
     {
            if (ReservationVoyage::where('slug','=',$slug)->first()){
            $id = ReservationVoyage::where('slug','=',$slug)->first()->id;
            showLog(ReservationVoyage::class,$id);
            return response()->json(['content'=>new ReservationVoyageResource(ReservationVoyage::where('slug','=',$slug)->first()),'message'=>'détail ReservationVoyage'],200,['Content-Type'=>'application/json']);
            }
          return response()->json(['message' => 'echec ,ReservationVoyage n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * la function qui permet de changer l'état d'une reservation
     */
    public function changeBookStatut(Request $request, $id) {
        $new_statut = $request->statut;

        // on récupère la réservation
        $book = ReservationVoyage::where('id','=',$id)->first();

        $book->statut = $new_statut;

        if($new_statut == "2") { // Alors ond oit génerer un billet
            $billet = $this->generatePDF($id);
            $book->billet = $billet->id;
        }
        $book->update();
        return response()->json('success');
    }

    public function generatePDF($idReservation) {

        $pool = 'KSHDJSHDKQH257322SDUZTDUYT86E83E9837E3EGYETTZDGJZTD65E37TE83E58E6JGJSGZSZ257Z762Z';

        $book = ReservationVoyage::where('id','=', $idReservation)->first();

        $typePiece = TypePiece::where('id' , '=' , $book->type_piece)->first();
        $classe = Classe::where('id', '=' , $book->classe)->first();
        $voyage = Voyage::where('id' , '=' , $book->voyage)->first();
        $partenaire = Partenaire::where('id' , '=' , $voyage->partenaire)->first();
        $itineraire = Itineraire::with('getVilleArrivee', 'getVilleDepart')
            ->where('id', '=' , $voyage->itineraire)->first();

        $numero_billet = '#RCGV'.$date = date('dmyYHis');
        $now = new \DateTime();
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template.docx'));
        $my_template->setValue('numero_recu', $numero_billet);
        $my_template->setValue('date_depart', $this->convertDateToHuman($voyage->date_depart));
        $my_template->setValue('heure', $voyage->heure_depart);
        $my_template->setValue('ville_depart', $itineraire->getVilleDepart->nom);
        $my_template->setValue('ville_arrivee', $itineraire->getVilleArrivee->nom);
        $my_template->setValue('name', $book->nom_voyageur.' '.$book->prenom_voyageur);
        $my_template->setValue('piece', $typePiece->libelle);
        $my_template->setValue('num_piece', ''.$book->numero_piece);
        $my_template->setValue('age', $book->age_voyageur == '2' ? 'Adulte': 'Enfant');
        $my_template->setValue('prix', $book->prix_voyage.' F CFA');
        $my_template->setValue('partenaire', $partenaire->nom_partenaire);
        $my_template->setValue('date_reservation', ''.$book->date_reservation);
        $my_template->setValue('date_impression', $now->format('Y-m-d H:i:s'));
        $my_template->setValue('classe', ''.$classe->libelle);
        $my_template->setValue('num_voyage', ''.$voyage->numero);

        try{
            $date = date('dmyYHis');
            $random_string = substr(str_shuffle(str_repeat($pool, 5)), 0 , 10);

            // création du nom du fichier
            $filename = $date. $random_string.'.docx';
            $my_template->saveAs(storage_path($filename));

        }catch (\Exception $e){
            //handle exception
            dd('ça ne marche pas !');
        }

        ConvertApi::setApiSecret('x8tccfel3eUnGnCo');
        $result = ConvertApi::convert('pdf', ['File' => storage_path($filename)]);

        # save to file
        $result->getFile()->save(storage_path('app/public/billets/'.$date.$random_string.'.pdf'));

        $url = Storage::url('billets/'.$date.$random_string.'.pdf');
        $data = [
            "code_barre" => "Code barrre",
            "slug" => str_randomize(20),
            "validite" => true,
            "url_pdf" => $url,
            "numero" => $numero_billet,
            "reservation_voyage" => $idReservation
            ];
        $billet  = Billet::create($data);
        return $billet;
    }

    function convertDateToHuman($dateToConvert) {
        setlocale(LC_TIME, 'fr');
        $new_date = $dateToConvert;
        $date = ucfirst(strftime('%A , %d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));

        return $date;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
          if (ReservationVoyage::where('slug','=',$slug)->first()){
           $reservationvoyage = ReservationVoyage::where('slug','=',$slug)->first();
           $data = [
             'date_reservation' =>$request->date_reservation,
             'date_validation' =>$request->date_validation,
             'dateVoyage' =>$request->dateVoyage,
             'statut' =>$request->statut,
             'nom_voyageur' =>$request->nom_voyageur,
             'client' =>$request->client,
             'slug' =>str_slug(name_generator('reservation',10),'-')
           ];
           if ($reservationvoyage->update($data)){
               $reservationvoyage =ReservationVoyage::where('slug','=',$slug)->first();
               updateLog(ReservationVoyage::class,$reservationvoyage->id);
               return response()->json(['message' => ' ReservationVoyage mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(ReservationVoyage::class,$reservationvoyage->id);
          return response()->json(['message' => ' echec mise à jours ReservationVoyage  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(ReservationVoyage::class,setZero());
      return response()->json(['message' => ' ReservationVoyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function destroy(Request $request,$slug)
     {
              if (ReservationVoyage::where('slug','=',$slug)->first()){
                    $reservationvoyage = ReservationVoyage::where('slug','=',$slug)->first();
                    $reservationvoyage->delete();
                    deleteLog(ReservationVoyage::class,$id);
                    return response()->json(['message' => ' ReservationVoyage supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(ReservationVoyage::class,setZero());
        return response()->json(['message' => ' ReservationVoyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


    public function payeWithPvit(Request $request){
        $reserve_id = $request->reservation_id;
        $amount = $request->amount;
        $phone = $request->phone;
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.MFowNC82VVRyQkRhenBwY1hBZUthd1VDNmh1d1VtZW10TUZkbmlwazhuckwvU0U4ZnBiRThJbjQveGEzNnhVZ2FaRXl0eXZxNmJXOEg2WktxbHNtUytFR2o0dkpMdmdLaDlkZzVMTWZVWHlDZGJPMjhuc252TFZzMDgzN0MyUWpMU3M0YVBLVFlFbWxTeHZrSTVTZUpTakd2c1M5KzJ3OWNsMnFDRkptT05ubkhIbjJ4R3hPU1MzSnA4N2FQWlQ5Ojo0elZqclh4ZGxQQ3VMKzVyMkhLWlBRPT0=.lPTp5KbFB6+BYkCx5LnD+HSht1DVkPbMbEHXql5e7II=";
        $r = ReservationVoyage::find($reserve_id);
        $transaction_id = "GV".substr(time(),-9);
        if ($r) {
            $r->statut = 1;
            $r->reference = $transaction_id;
            $r->save();
        }

        

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/mypvitapi.kk");
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"tel_marchand=074814529&montant=".$request->amount."&tel_client=".$request->phone."&ref=".$transaction_id."&token=".$token);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$resultat = curl_exec($ch);
		if($resultat){
			return response()->json(['resultat'=>true, 'message'=>'Transaction initiee avec succes']); 
		}else{
            $error_msg = curl_error($ch);
			return response()->json(['resultat'=>false, 'message'=>$error_msg]);
		}
    }
    
    public function callback(Request $request) {
        $data_received=file_get_contents("php://input");
        $data_received_xml=new SimpleXMLElement($data_received);
        $ligne_response=$data_received_xml[0];
        $reference_received=$ligne_response->REF;
        $statut_received=$ligne_response->STATUT;
        $client_received=$ligne_response->TEL_CLIENT;
        $type_received=$ligne_response->TYPE;
        $token_received=$ligne_response->TOKEN; 
        $res = ReservationVoyage::find($reference_received);
        if ( $statut_received == 200) {
            $res->statut = 2;
        } else {
            $res->statut = 3;
        }
        $res->save();
    }

}
