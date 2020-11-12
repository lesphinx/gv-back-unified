<?php

namespace App\Http\Controllers\API;

use App\Agence;
use Activation;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileUpLoad;
use App\Http\Resources\Partenaire as PartenaireResource;
use App\Image;
use App\Location;
use App\Partenaire;
use App\PiecesJointes;
use App\Role;
use App\User;
use App\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PartenaireController
|
|
|
|*/


class PartenaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!PartenaireResource::collection(Partenaire::all())->isEmpty()) {
            fetchLog(Partenaire::class);
            return response()->json([
                'content' => Partenaire::orderBy('nom_partenaire', 'desc')->get(),
                'message' => 'liste des Partenaires'],
                200,
                ['Content-Type' => 'application/json']);

        }
        fetchEmptyLog(Partenaire::class);
        return response()->json(['message' => 'Partenaires empty']);

    }


    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $assert_false = 0;
        $assert_true = 1;

        /**
         *
         *  Ici les champs à valider, soumit depuis la requette post
         */


        $rules = [
            'name' => 'required|string|min:2|max:100',
            'type_partenaire' => 'required',
            'adresse_partenaire' => 'required',
            'email_partenaire' => 'required|string|email|unique:users,email',
            //'logo' => 'nullable|image|max:1014',
            'libelle_agence' => 'required|string|min:2|max:100',
            'adresse_agence' => 'required|string|min:2',
            'email_agence' => 'email|unique:agences,email|nullable',
            'description'=>'string|min:30|nullable'
        ];

        /**
         *
         * Megasse de validation
         */
        $messages = [
            'name.required' => 'Le champ nom est obligatoire !',
            'name.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'name.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'name.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'email_partenaire.required' => 'Le champ  email est obligatoire ! ',
            'email_partenaire.email' => 'L\'adresse email est invalide',
            'email_partenaire.unique' => 'Cette adresse email est déja occupé !',
            'email_agence.email' => 'L\'adresse email de L\'agence est invalide',
            'email_agence.unique' => 'Cette adresse email pour L\'agence est déja occupée !',
            'type_partenaire.required' => 'Le champ  type partenaire est obligatoire ! ',
            'adresse_partenaire.required' => 'Le champ  adresse partenaire est obligatoire ! ',
            'description.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description.min' => 'Le champ description doit contenir au moins 30 charactères !',
            'logo.image' => 'Choisissez une image',
            'logo.mimes' => 'Choissiez un fichier de type jpeg, bmp ou png',
            'logo.max' => 'L\'image ne doit pas dépasser 1 Mo',
            'libelle_agence.required' => 'Le champ nom de l\'agence est obligatoire !',
            'libelle_agence.string' => 'Le champ nom de l\'agence doit contenir des chaines de charactères !',
            'libelle_agence.min' => 'Le champ nom de l\'agence doit contenir au moins deux charactères !',
            'libelle_agence.max' => 'Le champ nom de l\'agence ne doit pas exceder 100 charactères !',
            'adresse_agence.required' => 'Le champ adresse de l\'agence est obligatoire !',
            'adresse_agence.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'adresse_agence.min' => 'Le champ nom doit contenir au moins deux charactères !',
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


        /**
         * sinon le code continue par s'executer
         */


        $data = [
            'email_user' => $request->email_partenaire,
            'telephone_user' => $request->telephone,
            'langue_user' => $request->langue,
            'nom_partenaire' => $request->name,
            'type_partenaire' => $request->type_partenaire,
            'adresse_partenaire' => $request->adresse_partenaire,
            'description_partenaire' => $request->description,
            'site_web_partenaire' => $request->site_web,
            'etat_partenaire' => 1,
            'libelle_agence' => $request->libelle_agence,
            'adresse_agence' => $request->adresse_agence,
            'email_agence' => $request->email_agence,
            'ville_agence' => $request->ville_agence,
            'contact_agence' =>$request->contact_agence,
            'longitude_agence' => $request->longitude_agence,
            'latitude_agence' => $request->latitude_agence,
        ];

        /**
         * Determinons le role a affecter à l'utilisateur
         */
        $role = Role::where('name', 'Partenaire')->first();

        $data_user = [
            'email' => $data['email_user'],
            'password' => Hash::make('default-for-admin-only'),
            'slug' => str_randomize(20),
            'langue' => $data['langue_user'],
            'telephone' => $data['telephone_user'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => $role->id,
        ];


        // Gestion du logo du partenaire
        if ($request->logo != null) {
            $var_image = FileUpLoad::uf_base64($request->logo, 'logos');
        } else {
            $var_image = null;
        }

        /**
         * Creation d'un compte utilisateur
         */
        $user = User::create($data_user);

        /**
         *
         * On fait une assertion si le user est créee avec succès
         * on Commence par créer un le partenaire
         * on recupère un compte precis avec le slug de $data_user (unique)
         */
        if ($user) {
            $role_ = $user->role;

            $data_partenaire = [
                'nom_partenaire' => $data['nom_partenaire'],
                'type_partenaire' => $data['type_partenaire'],
                'adresse' => $data['adresse_partenaire'],
                'description' => $data['description_partenaire'],
                'site_web' => $data['site_web_partenaire'],
                'slug' => str_randomize(20),
                'etat' => 1,
                'utilisateur' => $user->id,
                'logo' => $var_image,
            ];


            /**
             * On recupere le partenaire qu 'on vient de créer par son slug
             */
            $partenaire_ = Partenaire::create($data_partenaire);

            $data_agence = [
                'libelle' => $data['libelle_agence'],
                'adresse' => $data['adresse_agence'],
                'email' => $data['email_agence'],
                'slug' => str_randomize(20),
                'ville' => $data['ville_agence'],
                'contact' =>$data['contact_agence'],
                'longitude' => $data['longitude_agence'],
                'latitude' => $data['latitude_agence'],
                'partenaire' => $partenaire_->id
            ];

            /**
             * On crée l'agence principale
             */

            $agence_principale = Agence::create($data_agence);


            /**
             * Gestion des pieces jointes
             *
             */
            if ($request->pieces_jointes != null) {
                foreach($request->pieces_jointes as $p) {
                    $file_url = FileUpLoad::uf_base64($p, 'pieces_jointes');
                    PiecesJointes::create([
                        'url_file' => $file_url,
                        'owner' => $partenaire_->id,
                        'slug' => str_randomize(20)
                    ]);
                }
            }


            // on attribue l'agence principale au partenaire'
            $partenaire_->agence_principale  = $agence_principale->id;

            $partenaire_->update();

            /**
             * On syncronique le role et utilisateur qu'on
             * vient d'ajouter
             */

            $user->roles()->sync([$role_]);

            return response()->json(['message' => 'Partenaire ajouté avec succès', 'status' => $assert_true]);
        }
        return response()->json(['message' => 'erreur  recommencez svp !', 'status' => $assert_false]);

    }




    /**
     * Recherche approfindi du partenaire
     */

    public function deeper_search_villes(Request $request, $key) {

        $partenaires = DB::table('partenaires')
            ->join('agences', 'agences.partenaire', '=', 'partenaires.id')
            ->join('villes', 'villes.id', '=', 'agences.ville')
            ->where('villes.nom' , '=' , $key)
            ->whereNull('partenaires.deleted_at')
            ->whereNull('villes.deleted_at')
            ->whereNull('agences.deleted_at')
            ->select('partenaires.*')
            ->get();

        return response()->json($partenaires);
    }


    public function deeper_search_pays(Request $request, $key) {

        $partenaires = DB::table('partenaires')
            ->join('agences', 'agences.partenaire', '=', 'partenaires.id')
            ->join('villes', 'villes.id', '=', 'agences.ville')
            ->join('pays', 'pays.id' , '=' , 'villes.pays')
            ->whereNull('partenaires.deleted_at')
            ->whereNull('villes.deleted_at')
            ->whereNull('agences.deleted_at')
            ->where('pays.nom' , '=' , $key)
            ->select('partenaires.*')
            ->get();

        return response()->json($partenaires);
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activation(Request $request, $slug)
    {
        $partenaire = Partenaire::where('slug' , $slug)->first();

        $user = User::where('id',$partenaire->utilisateur)->first();

        $activation = Activation::completed($user);

        if($activation){
            $partenaire->etat = 2 ;
            $partenaire->update();
            return response()->json(['message' => 'Ce compte est déja activé']);
        }
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

       // $to_name = $partenaire->nom_partenaire;
        $to_name = 'VIDILA Saint';
        $to_email =  'ibrahimkoubaye@gmail.com';
       // $to_email =  $user->email;

        $data = array('login'=>$user->email,'password'=>'default-for-admin-only');

        Mail::send('mails.active_compte_partenaire',$data,function($message) use ($to_name,$to_email){
        $to_name = 'VIDILA Saint';
            $messsage->to($to_email,$to_name)
            ->subject('Activation du compte');
            $message->from('vidilasaint@gmail.com','VIDILA SAINT');
        });

        $role = $user->roles()->first()->name;
        
        return response()->json(['message' => 'Compte activé avec succès !']);
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivation(Request $request,$slug){
        $partenaire = Partenaire::where('slug' , $slug)->first();

        $user = User::where('id',$partenaire->utilisateur)->first();
        Activation::remove($user);

        $partenaire->etat = 1 ;
        $partenaire->update();
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);
    }

    public function bloquer(Request $request,$slug){
        $partenaire = Partenaire::where('slug' , $slug)->first();

        $partenaire->etat = 3 ;
        $partenaire->update();
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);
    }


    public function debloquer(Request $request,$slug){
        $partenaire = Partenaire::where('slug' , $slug)->first();

        $partenaire->etat = 2 ;
        $partenaire->update();
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request,$slug)
    {
        if (Partenaire::where('slug','=',$slug)->first()){
            $id = Partenaire::where('slug','=',$slug)->first()->id;
            showLog(Partenaire::class,$id);
            return response()->json(
                [ 'content'=>new PartenaireResource(Partenaire::where('slug','=',$slug)->first()),
                  'message'=>'détail Partenaire'],
            200,['Content-Type'=>'application/json']);
        }

        notFoundLog(Partenaire::class, setZero());
        return response()->json(['message' => 'echec ,Partenaire n\existe pas'],404,['Content-Type'=>'application/json']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request,$slug) {

        $partenaire = Partenaire::where('slug','=',$slug)->first();
        if ($partenaire){
            $partenaire->nom_partenaire = $request->name;
            $partenaire->adresse = $request->adresse_partenaire;
            $partenaire->numero_tel = $request->numero_tel;
            $partenaire->type_partenaire = $request->type_partenaire;
            $partenaire->description = $request->description;
            $partenaire->site_web = $request->site_web;

            // On teste si on a envoyé une image
            if($request->logo != null ) {
                $var_image = FileUpLoad::uf_base64($request->logo, 'logos');
                if($partenaire->logo != null) {
                    // On doit supprimer l'image qui existait déjà dans le disque
                    $old_image = $partenaire->logo;
                    FileUpLoad::remove_base64_file($old_image);
                }
                $partenaire->logo = $var_image;
            } else {
                $partenaire->logo = null;
            }

            if ($partenaire->update()){

                $partenaire =Partenaire::where('slug','=',$slug)->first();

                updateLog(Partenaire::class,$partenaire->id);

                return response()->json(['message' => ' Partenaire mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Partenaire::class,$partenaire->id);
                return response()->json(['message' => ' echec mise à jours Partenaire  !'],400,['Content-Type'=>'application/json']);
            }
            notFoundLog(Partenaire::class,setZero());
            return response()->json(['message' => ' Partenaire n\'existe pas !'],404,['Content-Type'=>'application/json']);        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (!Partenaire::where('slug' , $slug)->get()->isEmpty()){
            $partenaire = Partenaire::where('slug', $slug)->first();


            // On récupère le user lié au partenaire

            if (!User::where('id','=', $partenaire->utilisateur)->get()->isEmpty()) {
                $user = User::where('id','=', $partenaire->utilisateur)->first();
                $user->delete();
            }


            // Récupération des agences du partenaire
            if (!Agence::where('partenaire', $partenaire->id)->get()->isEmpty()) {
                $agences = Agence::where('partenaire', $partenaire->id)->get();
                // On supprime toutes les agences
                foreach ($agences as $agence)
                    $agence->delete();
            }


            // on récupere l'id du partenaire pour le log
            $id = $partenaire->id;


            // On doit supprimer toutes les offres du partenaire

            // Les voyages
            $voyages = Voyage::where('partenaire', $id)->get();
            if (!$voyages->isEmpty()) {
                // On supprime toutes les agences
                foreach ($voyages as $voyage)
                    $voyage->delete();
            }

            // Les voyages
            $locations = Location::where('partenaire', $id)->get();
            if (!$locations->isEmpty()) {
                // On supprime toutes les agences
                foreach ($locations as $location)
                    $location->delete();
            }

            // Supprimer toutes les imgaes qui appartient au partenaire
            $images = Image::where('owner', $id)->get();
            if (!$images->isEmpty()) {
                // On supprime toutes les agences
                foreach ($images as $image) {
                    FileUpLoad::remove_base64_file($image->nom);
                    $image->delete();
                }
            }

            $partenaire->delete();

            deleteLog(Partenaire::class, $id);
            return response()->json(['message' => ' Partenaire supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Partenaire::class, setZero());
        return response()->json(['message' => ' Partenaire n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
