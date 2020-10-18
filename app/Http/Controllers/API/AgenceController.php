<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Agence as AgenceResource;
use App\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   AgenceController
|
|
|
|*/


class AgenceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if(!AgenceResource::collection(Agence::paginate(10))->isEmpty()){
            return response()->json(['content'=>Agence::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Agences'],200,['Content-Type'=>'application/json']);

        }
        return response()->json(['message'=>'Agences empty']);

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
         *
         *  Ici les champs à valider, soumit depuis la requette post
         */

        $rules = [
            'libelle' => 'required|string|min:2|max:100',
            'email' => 'email|unique:agences,email|nullable',
            'ville' => 'required',
            'contact' => 'required',
            'adresse' => 'required'
        ];



        /**
         *
         * Megasse de validation
         */
        $messages = [
            'ville.required' => 'Le champ Ville est obligatoire !',
            'contact.required' => 'Le numéro de téléphone est obligatoire !',
            'adresse.required' => 'L\'adresse est obligatoire !',
            'libelle.required' => 'Le nom de l\'agence est obligatoire !',
            'libelle.string' => 'doit contenir des chaines de charactères !',
            'libelle.min' => 'Le nom doit contenir au moins 2 charactères !',
            'libelle.max' => 'Le nom ne doit pas depasser 30 haractères !',
            'email.email' => 'L\'adresse email est invalide',
            'email.unique' => 'Cette adresse email est déja occupé !',
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
        $data = [
            'libelle' =>$request->libelle,
            'longitude' =>$request->longitude,
            'latitude' =>$request->latitude,
            'contact' =>$request->contact,
            'slug' => str_randomize(20),
            'adresse' =>$request->adresse,
            'email' =>$request->email,
            'ville' =>$request->ville,
            'partenaire' =>$request->partenaire
        ];

        if (Agence::create($data)) {
            return response()->json(['message' => ' Agence crée avec succès', 'status' => $assert_true]);

        }
        return response()->json(['message'=>'echec de création Agence']);


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
        if (Agence::where('slug','=',$slug)->first()){
            $id = Agence::where('slug','=',$slug)->first()->id;
            return response()->json(['content'=>new AgenceResource(Agence::where('slug','=',$slug)->first()),'message'=>'détail Agence'],200,['Content-Type'=>'application/json']);
        }

        return response()->json(['message' => 'echec ,Agence n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function update(Request $request, $slug)
    {

        $agence = Agence::where('slug','=',$slug)->first();

        if($agence){
            if ($request->libelle != null ) {
                $agence->libelle = $request->libelle;
            }

            if ($request->contact != null ) {
                $agence->contact = $request->contact;
            }

            if ($request->adresse != null ) {
                $agence->adresse = $request->adresse;
            }

            if ($request->ville != null ) {
                $agence->ville = $request->ville;
            }

            if ($request->latitude != null ) {
                $agence->latitude = $request->latitude;
            }

            if ($request->longitude != null ) {
                $agence->longitude = $request->longitude;
            }


            if ($agence->update()){
                return response()->json(['message' => ' Agence mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                return response()->json(['message' => ' echec mise à jours Agence  !'],400,['Content-Type'=>'application/json']);
            }

        }

        return response()->json(['message' => ' Agence n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Agence::where('slug','=',$slug)->first()){
            $agence = Agence::where('slug','=',$slug)->first();
            return response()->json(['message' => ' Agence supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        return response()->json(['message' => ' Agence n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
