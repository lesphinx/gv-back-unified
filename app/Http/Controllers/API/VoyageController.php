<?php

namespace App\Http\Controllers\API;
use App\ClasseVoyage;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileUpLoad;
use App\Http\Resources\Voyage as VoyageResource;
use App\Http\Resources\VoyageCollection;
use App\Image;
use App\Itineraire;
use App\Partenaire;
use App\VilleItineraire;
use App\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   VoyageController
|
|
|
|*/


class VoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // voyage?page=3&parPage=2
        $parPage = $request->input('parPage');
        $currentPage = $request->input('page');
        $client = $request->input('client');

        $now = new \DateTime();
        if( $client == 1 ) {
            $voyages = new VoyageCollection(
                Voyage::where('date_depart' ,'>=' , $now->format('Y-m-d'))
                        ->where('nombre_place', '>' , '0')
                        ->where('etat' , '=' , '3') // On récupère seulement les voyage déjà publié
                        ->paginate(300));

        } else {
            $voyages = new VoyageCollection(
                Voyage::paginate($perPage = $parPage, $columns = ['*'], $pageName = 'page', $page = $currentPage));
        }

        return response()->json(['content'=> $voyages, 'message'=>'Liste de voyage'], 200);

    }


    public function voyagePartenaire(Request $request,$slug) {

        $partenaire = Partenaire::where('slug', '=', $slug)->first();

        if (VoyageResource::collection(Voyage::where('partenaire', '=' , $partenaire->id)->get())) {
            return response()->json(
                ['content'=> VoyageResource::collection(Voyage::where('partenaire', '=' , $partenaire->id)->get()),
                    'message'=>'Liste de voyage'], 200);
        }
        return response()->json(['content'=>  [], 'message'=>'Pas de voyages'], 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $assert_false = 0;
        $assert_true = 1;

        /**
         * Les régles de validations
         */

        $rules = [
            'nombre_place' => 'required|numeric',
            'moyen_transport' => 'required',
            'partenaire'=>'required',
            'ville_depart' => 'required',
            'date_depart' => 'required',
            'ville_arrivee' => 'required',
            'heure_depart' => 'required',
            'description'=>'string|min:30|nullable',
            'num_voyage'=>'required'
        ];


        /**
         * Message de validation
         */

        $messages = [
            'nombre_place.required' => 'Champ obligatoire.',
            'numbre_place.numeric' => 'Ce champ doit être un nombre',
            'moyen_transport.required' => 'Champ obligatoire.',
            'partenaire.required' => 'Champ obligatoire.',
            'ville_depart.required' => 'Champ obligatoire.',
            'ville_arrivee.required' => 'Champ obligatoire.',
            'date_depart.required' => 'Champ obligatoire.',
            'heure_depart.required' => 'Champ obligatoire.',
            'num_voyage.required' => 'Champ obligatoire.',
            'description.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description.min' => 'Le champ description doit contenir au moins 30 charactères !',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        /**
         * Si le formulaire contient des erreur
         */
        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }



        // On recupère l'id du useur connecté
        //$id_user = Sentinel::getUser()->id;

        // Calculer etat en fonction du type d'utilisateur qui crée le voyage
        $etat = 1;


        $tarifs = $request->tarif;


        // On doit maintenant crée un itinéraire

        $new_itineraire = [
            'ville_depart' => $request->ville_depart,
            'ville_arrivee' => $request->ville_arrivee,
            'description' => '',
            'slug' => str_slug(name_generator('itineraire', 10), '-'),
        ];


        if (Itineraire::create($new_itineraire)) {
            createLog(Itineraire::class);

            // On recupère l'itinéraire qu'on vient d ecréer
            $itiner = Itineraire::where('slug' , $new_itineraire['slug'])->first();


            $rang = 1 ;
            // On ajoute des villes à l'itnéraire
            foreach ($request->itineraire as $i ) {
                $new_ville_it = [
                    'rang' => $rang,
                    'ville' => $i['ville'],
                    'itineraire' => $itiner->id,
                    'escale' => $i['escale'],
                    'slug' => str_randomize(20)
                ];

                VilleItineraire::create($new_ville_it);
                $rang ++;
            }



            // Gestion de l'image du vouage
            if ($request->image_voyage != null) {
                $image_url = FileUpLoad::uf_base64($request->image_voyage, 'voyages');
                $new_image = Image::create([
                    'nom' => $image_url,
                    'owner' => $request->partenaire,
                    'slug' => str_randomize(20)
                ]);
                $var_image = $new_image->id;
            } else {
                $var_image = null;
            }

            // On crée le voyage
            $new_voyage = [
                'image' => $var_image,
                'numero' =>$request->num_voyage,
                'date_depart' => $request->date_depart,
                'heure_depart' => $request->heure_depart,
                'description' =>$request->description,
                'duree' =>$request->duree_voyage,
                'nombre_place' =>$request->nombre_place,
                'moyen_transport' =>$request->moyen_transport,
                'slug' =>str_slug(name_generator('voyage',10),'-'),
                'partenaire' => $request->partenaire,
                'etat' => $etat,
                'valider_par' =>1, // l'utilisateur qui fait l'enrefistrement si c'est un admin
                'itineraire' => $itiner->id

            ];

            if (Voyage::create($new_voyage)) {

                createLog(Voyage::class);

                $voyage_created = Voyage::where('slug', $new_voyage['slug'])->first();

                // On doit maintenant enregistrer les tarifs en fonction des classe d voyages
                foreach ($tarifs as $tarif ) {

                    $new_classe_voyage = [
                        'prix_enfant' => $tarif['prix_enfant'] != null ? $tarif['prix_enfant'] : $tarif['prix_adulte'],
                        'prix_adulte' => $tarif['prix_adulte'],
                        'classe' => $tarif['classe'],
                        'voyage' =>$voyage_created->id,
                        'slug' => str_slug(name_generator('class-voyage', 10), '-'),

                    ];

                    // On ne crée que si on a renseigner l'un des deux prix
                    if( $new_classe_voyage['prix_adulte']!= null || $new_classe_voyage['prix_enfant'] != null) {
                        if (ClasseVoyage::create($new_classe_voyage)) {
                            createLog(ClasseVoyage::class);

                        }else {
                            createFailureLog(ClasseVoyage::class);
                        }
                    }
                }

                return response()->json(
                    [
                        'status' => $assert_true,
                        'message' => 'Voyage créé avec succès!'
                    ]
                );
            }

        }else {
            createFailureLog(Itineraire::class);
        }

        createFailureLog( Voyage::class);
        return response()->json(['message'=>'echec de création Voyage']);
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
        if (Voyage::where('slug','=',$slug)->first()){
            $id = Voyage::where('slug','=',$slug)->first()->id;
            showLog(Voyage::class,$id);
            return response()->json(['content'=>new VoyageResource(Voyage::where('slug','=',$slug)->first()),'message'=>'détail Voyage'],200,['Content-Type'=>'application/json']);
        }

        notFoundLog(Voyage::class, setZero());
        return response()->json(['message' => 'echec ,Voyage n\existe pas'],404,['Content-Type'=>'application/json']);
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
        $voyage = Voyage::where('slug','=',$slug)->first();
        if ($voyage){

            $itineraire = Itineraire::where('slug' , '=' , $request->itineraire)->first();

            if ($itineraire) {

                if ($request->ville_depart != null) {
                    $itineraire->ville_depart = $request->ville_depart;
                }
                if ($request->ville_arrivee != null) {
                    $itineraire->ville_arrivee = $request->ville_arrivee;
                }

                $itineraire->update();
            } else {
                $new_itineraire = [
                    'ville_depart' => $request->ville_depart,
                    'ville_arrivee' => $request->ville_arrivee,
                    'description' => '',
                    'slug' => str_slug(name_generator('itineraire', 10), '-'),
                ];

                $new_it = Itineraire::create($new_itineraire);
                $voyage->itineraire = $new_it->id;
            }


            // Gestion de l'itineraire

            // On supprime d'abord de la base les villes qu'on a rétiré de l'itineraire
            foreach ($request->deleted_ville_itineraire as $i ) {
                VilleItineraire::where('id' , '=' , $i)->delete();
            }

            // Ajoute les autres ville
            $rang = 1 ;
            $itineraire = Itineraire::where('slug' , '=' , $request->itineraire)->first();

            foreach ($request->ville_itineraire as $ville) {
                if ($ville['id'] != 0) {
                    // c'est une ville qui existait déjà on modifie seulement son rang
                    $new_ville = VilleItineraire::where('id', '=' , $ville['id'])->first();
                    $new_ville->rang = $rang;
                    $new_ville->ville = $ville['ville'];
                    $new_ville->escale = $ville['escale'];
                    $new_ville->update();
                } else {
                    // C'est une nouvelle ville, on l'ajoute à l'itineraire
                    $new_ville_it = [
                        'rang' => $rang,
                        'ville' => $ville['ville'],
                        'itineraire' => $itineraire->id,
                        'escale' => $ville['escale'],
                        'slug' => str_randomize(20)
                    ];
                    VilleItineraire::create($new_ville_it);
                }
                $rang ++;
            }

            // Gestion de l'image du vouage
            if ($request->image != null) {
                $image_url = FileUpLoad::uf_base64($request->image, 'voyages');
                $new_image = Image::create([
                    'nom' => $image_url,
                    'owner' => $request->partenaire,
                    'slug' => str_randomize(20)
                ]);
                $voyage->image = $new_image->id;
            }


            if($request->num_voyage != null){
                $voyage->numero = $request->num_voyage;
            }

            if($request->description != null) {
                $voyage->description = $request->description;
            }

            if($request->date_depart != null) {
                $voyage->date_depart = $request->date_depart;
            }


            if( $request->heure_depart != null) {
                $voyage->heure_depart = $request->heure_depart;
            }

            if($request->nombre_place != null) {
                $voyage->nombre_place = $request->nombre_place;
            }

            if($request->duree != null) {
                $voyage->duree = $request->duree;
            }

            if($request->partenaire != null ) {
                $voyage->partenaire = $request->partenaire;
            }
            if($request->moyen_transport != null ) {
                $voyage->moyen_transport = $request->moyen_transport;
            }


            // mise à jour des tarifs dans la table classe voyage
            foreach ($request->tarif as $t) {
                $new_classe_voyage = [
                    'prix_enfant' => $t['prix_enfant'],
                    'prix_adulte' => $t['prix_adulte'],
                    'classe' => $t['classe'],
                    'voyage' => $voyage->id,
                    'slug' => str_slug(name_generator('class-voyage', 10), '-'),
                ];

                // On se rassure qu'au moins l'un des prix est renseigneé
                if ($new_classe_voyage['prix_enfant'] != null || $new_classe_voyage['prix_adulte'] != null) {
                    if($t['id'] != null) {
                        $classe_voyage = ClasseVoyage::where('id' , '=' , $t['id'])->first();
                        if($classe_voyage) {
                            $classe_voyage->update($new_classe_voyage);
                        }
                    }else {
                        ClasseVoyage::create($new_classe_voyage);
                    }
                }
            }


            if ($voyage->update()){
                updateLog(Voyage::class, $voyage->id);
                return response()->json(['message' => ' Voyage mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Voyage::class, $voyage->id);
                return response()->json(['message' => ' echec mise à jours Voyage  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Voyage::class,setZero());
        return response()->json(['message' => ' Voyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function destroy($slug)
    {
        if (!Voyage::where('slug','=',$slug)->get()->isEmpty()){

            $voyage = Voyage::where('slug','=',$slug)->firstOrFail();

            $id_voyage = $voyage->id;

            // Suppression des tarifs dans la table ClasseVoyage
            foreach (ClasseVoyage::where('voyage' , '=' , $id_voyage)->cursor() as $tarif) {

                $id_tarif = $tarif->id;

                $tarif->delete();
                deleteLog(ClasseVoyage::class , $id_tarif);
            }

            $voyage->delete();
            deleteLog(Voyage::class, $id_voyage);

            return response()->json(['message' => ' Voyage supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Voyage::class,setZero());
        return response()->json(['message' => ' Voyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }



    /**
     * La function qui permet de changer l'etat d'un voyage dans la base de données
     */
    public function change_state($slug) {

        $voyage = Voyage::where('slug','=',$slug)->first();

        if($voyage != null) {
            if($voyage->etat == 4) {
                $voyage->etat = 3;
            }else {
                $voyage->etat ++;
            }

            $voyage->update();
            updateLog(Voyage::class, $voyage->id);
            return response()->json([
                'etat' => $voyage->etat,
                'message' => 'Etat changé avec succès'
            ],200,['Content-Type'=>'application/json']);
        }
        notFoundLog(Voyage::class, setZero());
        return response()->json([
            'message' => 'Voayge non trouvé'
        ],404,['Content-Type'=>'application/json']);
    }


    public function deeper_search(Request $request) {
        //On recupère tous les voyages
        $voyages = Voyage::orderBy('created_at','desc')
                            ->join('itineraires', 'itineraires.id', '=', 'itineraire')
                            ->join('classe_voyages', 'voyages.id', '=' , 'classe_voyages.voyage')
                            ->join('villes as villes_depart_table' , 'villes_depart_table.id', '=', 'itineraires.ville_depart')
                            ->join('villes as villes_arrivee_table' , 'villes_arrivee_table.id', '=' ,'itineraires.ville_arrivee');


        $client = $request->input('client') ;
        if ($client == 1 ){
            $voyages = $voyages->where('date_depart' ,'>=' , new \DateTime());
        }

        if ($request->max_price != null) {
            $voyages = $voyages->where('prix_adulte', '<=' , $request->max_price);
        }
        if ($request->min_price != null) {
            $voyages = $voyages->where('prix_adulte', '>=' , $request->min_price);
        }

        if( $request->ville_depart != null ) {
            $voyages = $voyages->where('itineraires.ville_depart' , '=' , $request->ville_depart);
        }


        if( $request->partenaire != null ) {
                    $voyages = $voyages->where('voyages.partenaire' , '=' , $request->partenaire);
        }

        if( $request->ville_arrivee != null ) {
            $voyages = $voyages->where('itineraires.ville_arrivee' , '=' , $request->ville_arrivee);
        }

        if ($request->pays_depart != null) {
            $voyages = $voyages->where('villes_depart_table.pays', '=' , $request->pays_depart );
        }

        if ($request->pays_arrive != null) {
            $voyages = $voyages->where('villes_arrivee_table.pays', '=' , $request->pays_arrive );
        }

        if ($request->date_debut != null) {
            $voyages = $voyages->where('voyages.date_depart', '>=', $request->date_debut);
        }

        if ($request->date_fin != null) {
            $voyages = $voyages->where('voyages.date_depart', '<=', $request->date_fin);
        }

        if ($request->moyen_transport != null ) {
            $voyages = $voyages->where('voyages.moyen_transport', '=', $request->moyen_transport);
        }

        if ($request->etat_voyage != null ) {
            $voyages = $voyages->where('voyages.etat', '=', $request->etat_voyage);
        }
        return response()->json(VoyageResource::collection($voyages->select('voyages.*')->get()));
    }

    public function min_max_price() {
        $max_prix_adulte = ClasseVoyage::max('prix_adulte');

        $min_prix_adulte = ClasseVoyage::min('prix_adulte');

        return response()->json([
            'min' => $min_prix_adulte,
            'max' => $max_prix_adulte
        ]);

    }

}
