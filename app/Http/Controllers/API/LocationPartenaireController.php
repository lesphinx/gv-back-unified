<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileUpLoad;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\Voyage as VoyageResource;
use App\Image;
use App\Location;
use App\LocationImage;
use App\Partenaire;
use App\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Sentinel;
/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   LocationController
|
|
|
|*/


class LocationPartenaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $client = $request->input('client');
        $now = new \DateTime();
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

        if($client == 1) {
            if(!Location::all()->isEmpty()){
                fetchLog(Location::class);
                return response()->json([
                    'content'=>Location::with('getPartenaire', 'getVille', 'images')
                        ->orderBy('created_at','desc')
                        ->where('etat', '=', '3')
                        ->where('date_fin_disponibilite', '>=' , new \DateTime())
                        ->paginate(5),
                    'message'=>'liste des Locations'],
                    200,['Content-Type'=>'application/json']);

            }
        } else {
            if(!Location::all()->isEmpty()){
                fetchLog(Location::class);
                return response()->json([
                    'content'=>Location::with('getPartenaire', 'getVille', 'images')
                        ->where('partenaire', '=' , $partenaire->id)
                        ->orderBy('created_at','desc')
                        ->paginate(500),
                    'message'=>'liste des Locations'],
                    200,['Content-Type'=>'application/json']);

            }
        }
        fetchEmptyLog(Location::class);
        return response()->json(['message'=>'Locations empty']);

    }


    public function locationPartenaire(Request $request,$slug) {

        $partenaire = Partenaire::where('slug', '=', $slug)->first();

        if (LocationResource::collection(Location::where('partenaire', '=' , $partenaire->id)->get())) {
            return response()->json(
                ['content'=> Location::where('partenaire', '=' , $partenaire->id)
                                    ->with('getPartenaire', 'getVille', 'images')
                                    ->orderBy('created_at','desc')
                                    ->get(),
                    'message'=>'Liste de Location'], 200);
        }
        return response()->json(['content'=>  [], 'message'=>'Pas de Location'], 500);
    }


    public function deeper_search(Request $request) {
        //On recupère tous les voyages
        $client = $request->input('client');
        $locations = Location::orderBy('created_at','desc')
            ->join('villes', 'villes.id', '=', 'ville');

        if ($request->max_price != null) {
            $locations = $locations->where('prix_jour', '<=', $request->max_price);
        }

        if ($request->min_price != null) {
            $locations = $locations->where('prix_jour', '>=' , $request->min_price);
        }


       /*  if ($request->partenaire != null ) {
            $locations = $locations->where('locations.partenaire' , '=' , $request->partenaire);
        } */
        if ($client == 1 ) { // on prend juste les locations qui sont publié et qui sont encore à jour
            $locations =$locations->where('locations.etat', '=' , '3')
                                  ->where('date_fin_disponibilite', '>=' , new \DateTime());
        }

        if($request->mot_cle != '') {
            $locations = $locations->WhereRaw('lower(locations.titre) LIKE lower(?)',["%{$request->mot_cle}%"])
                                    ->orWhereRaw('lower(locations.description) LIKE lower(?)',["%{$request->mot_cle}%"]);
        }
        if( $request->ville != null ) {
            $locations = $locations->where('locations.ville' , '=' , $request->ville);
        }

        if ($request->pays != null) {
            $locations = $locations->where('villes.pays', '=' , $request->pays);
        }

        if ($request->date_debut != null) {
            $locations = $locations->where('locations.date_debut_disponibilite', '<=', $request->date_debut);
        }

        if ($request->date_fin != null) {
            $locations = $locations->where('locations.date_fin_disponibilite', '>=', $request->date_fin);
        }

        if ($request->etat != null ) {
            $locations = $locations->where('locations.etat', '=', $request->etat);
        }
        return response()->json(LocationResource::collection($locations->select('locations.*')->get()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $partenaire = Partenaire::where('utilisateur', '=', Sentinel::getUser()->id)->first();

       $data = [
           'partenaire' => $partenaire->id,
           'titre' =>$request->title,
           'ville' => $request->ville_location,
           'description'=>$request->description,
           'prix_jour' => $request->prix_jour,
           'date_debut_disponibilite'=>$request->date_debut,
           'slug'=>str_slug(name_generator('location',10),'-'),
           'date_fin_disponibilite'=>$request->date_fin,
           'etat'=>1
       ];


        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'title' => 'required|string|min:2',
            'description'=>'string|min:30|nullable',
            'ville_location' => 'required',
            'partenaire' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required',
            'prix_jour' => 'required'
        ];

        $messages = [
            'date_debut.required' => 'Champ obligatoire',
            'date_fin.required' => 'Champ obligatoire',
            'ville_location.required' => 'Vous devez choisir une ville',
            'partenaire.required' => 'Le champ Partenaire est obligatoire',
            'prix_jour.required' => 'Vous devez saisir le prix de location par jour.',
            'title.required' => 'Le champ titre est obligatoire !',
            'title.string' => 'Le champ titre doit contenir des chaines de charactères !',
            'title.min' => 'Le champ titre doit contenir au moins deux charactères !',
            'description.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description.min' => 'Le champ description doit contenir au moins 30 charactères !',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }
       if (Location::create($data)) {

           $location_created = Location::where('slug', '=' , $data['slug'])->first();

           // On enregistres les images
           foreach($request->photos as $p) {
               $image_url = FileUpLoad::uf_base64($p, 'locations');
               $new_image = Image::create([
                   'nom' => $image_url,
                   'owner' => $request->partenaire,
                   'slug' => str_randomize(20)
               ]);

               LocationImage::create([
                  'location' => $location_created->id,
                  'image' => $new_image->id,
                  'slug' => str_randomize(20)
               ]);
           }
         createLog(Location::class);
          return response()->json(['message' => ' Location crée avec succès'],200,['Content-Type'=>'application/json']);
       }
       createFailureLog( Location::class);
       return response()->json(['message'=>'echec de création Location']);
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
            if (Location::where('slug','=',$slug)->first()){
            $id = Location::where('slug','=',$slug)->first()->id;
            showLog(Location::class,$id);
            return response()->json(['content'=>new LocationResource(Location::where('slug','=',$slug)->first()),'message'=>'détail Location'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Location::class, $slug);
          return response()->json(['message' => 'echec ,Location n\existe pas'],404,['Content-Type'=>'application/json']);
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
        $location = Location::where('slug','=',$slug)->first();
        if ($location) {

           $location->titre = $request->title;
             // $location->partenaire = $request->partenaire;
           $location->description = $request->description;
           $location->date_debut_disponibilite =$request->date_debut;
           $location->prix_jour =$request->prix_jour;
           $location->date_fin_disponibilite =$request->date_fin;

           if ($request->ville_location != null ) {
               $location->ville = $request->ville_location;
           }

           if ($request->photos ) {
               // On enregistres les images
               foreach($request->photos as $p) {
                   $image_url = FileUpLoad::uf_base64($p, 'locations');
                   $new_image = Image::create([
                       'nom' => $image_url,
                       'owner' => $request->partenaire,
                       'slug' => str_randomize(20)
                   ]);

                   LocationImage::create([
                       'location' => $location->id,
                       'image' => $new_image->id,
                       'slug' => str_randomize(20)
                   ]);
               }
           }

            // On supprime les images
            if ($request->image_to_remove) {
                foreach($request->image_to_remove as $p) {
                    $image_location = LocationImage::where('image', '=', $p)
                        ->where('location' , '=', $location->id)
                        ->first();
                    $image_location->delete();

                }
            }

           if ($location->update()) {
              updateLog(Location::class,$location->id);
               return response()->json(['message' => ' Location mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           } else {
              updateFailureLog(Location::class,$location->id);
              return response()->json(['message' => ' echec mise à jours Location  !'],400,['Content-Type'=>'application/json']);
           }
        }

        notFoundLog(Location::class,setZero());
        return response()->json(['message' => ' Location n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Location::where('slug','=',$slug)->first()){
                    $location = Location::where('slug','=',$slug)->first();
                    $id = $location->id;
                    $location->delete();
                    deleteLog(Location::class,$id);
                    return response()->json(['message' => ' Location supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Location::class,setZero());
        return response()->json(['message' => ' Location n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }




    /**
     * La function qui permet de changer l'etat d'un voyage dans la base de données
     */
    public function change_state($slug) {

        $location = Location::where('slug','=',$slug)->first();

        if($location != null) {
            if($location->etat == 4) {
                $location->etat = 3;
            }else {
                $location->etat ++;
            }

            $location->update();
            updateLog(Location::class, $location->id);
            return response()->json([
                'message' => 'Etat changé avec succès'
            ],200,['Content-Type'=>'application/json']);
        }
        notFoundLog(Location::class, setZero());
        return response()->json([
            'message' => 'Location non trouvé'
        ],404,['Content-Type'=>'application/json']);
    }


    public function min_max_price() {
        $max_price = Location::where('etat', '=' , '3')->max('prix_jour');
        $min_price = Location::where('etat', '=' , '3')->min('prix_jour');


        return response()->json([
            'min' => $min_price,
            'max' => $max_price
        ]);

    }
}
