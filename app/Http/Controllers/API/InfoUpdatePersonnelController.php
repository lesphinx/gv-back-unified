<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


use App\User;
use App\Personnel;
use Carbon\Carbon;


class InfoUpdatePersonnelController extends Controller
{
    private $nom;
    private $prenom;
    private $sexe;
    private $email;
    private $role;
    private $telephone;
    private $langue;
    //
    private $matricule;
    private $date_embauche;
    private $date_naissance;
    // 
    private $password;
    private $permissions;
    private $last_login;
    private $remember_token;
    private $slug_user;
    private $slug_client;
    private $created_at_;
    private $created_at;
    private $user_id;


    private static function matches($needle, $haystack)
    {
        if ($needle === $haystack) {
            return true;
        }
        return false;
    }



    public function update(Request $request)
    {
        $_slug = $request->slug;

        if (Personnel::where('slug',$_slug)->first()){



            $data_ = [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'sexe' => $request->sexe,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'langue' => $request->langue,
                'date_naissance' => $request->date_naissance,
                'matricule' => $request->matricule,
                'date_embauche' => $request->date_embauche
            ];
            $dt = Carbon::now();

            $rules = [
                'nom' => 'string|min:2|max:100',
                'prenom' => 'string|min:2|max:100',
                'email' => 'string|email',
                'date_naissance' => 'date|before_or_equal:'.$dt,
                'matricule' => 'string|min:2',
                'date_embauche' => 'date|before_or_equal:'.$dt,
            ];

            $messages = [
                'nom.required' => 'Le champ nom est obligatoire !',
                'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
                'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
                'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
                'prenom.required' => 'Le champ nom est obligatoire !',
                'prenom.string' => 'Le champ nom doit contenir des chaines de charactères !',
                'prenom.min' => 'Le champ nom doit contenir au moins deux charactères !',
                'prenom.required' => 'Le champ prenom doit contenir au plus cent charactères !',
                'prenom.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
                'email.required' => 'Le champ  email est obligatoire ! ',
                'email.email' => 'L\'adresse email est invalide',
                'date_naissance.date' => 'La date de naissance est invalide',
                'date_embauche.before_or_equal' => 'La date d\'embauche doit etre la date du jours ou une date entérieure ! ',
                'date_naissance.before_or_equal' => 'La date de naissance doit etre la date du jours ou une date entérieure ! ',

                'matricule.required' => 'Le champ nom est obligatoire !',
                'matricule.string' => 'Le champ nom doit contenir des chaines de charactères !',
                'matricule.min' => 'Le champ nom doit contenir au moins deux charactères !',
                'date_embauche.date' => 'La date d\'embauche est invalide',
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                return response()->json([
                    'content' => [
                        'status' => 0,
                        'error' => $validator->errors(),
                        'message' => 'Le formulaire contient des erreurs',

                    ],
                ]);
            }


            $personnel = Personnel::where('slug',$_slug)->first();
            $user = User::where('id',$personnel->user_id)->first();

            $data_personnel = [
                'nom' => $personnel->nom,
                'prenom' => $personnel->prenom,
                'sexe' => $personnel->sexe,
                'slug' =>$personnel->slug,
                'date_embauche'=>$personnel->date_embauche,
                'matricule'=>$personnel->matricule,
                'date_naissance' => $personnel->date_naissance,
            ];



            $data_user = [
                'email' => $user->email,
                'role' => $user->role,
                'telephone' => $user->telephone,
                'langue' => $user->langue,
                'password' => $user->password,
                "permissions"	 => $user->permissions,
                "last_login"  => $user->last_login,
                "remember_token"	 => $user->remember_token,
                "slug"	 => $user->slug_client,
                "langue"		 => $user->langue,
                "telephone"		 => $user->telephone,
                "role"		 => $user->role,
                "created_at"	 => $user->created_at,
            ];

            // personnel

            if (self::matches($data_['nom'],$data_personnel['nom'])) {
                $this->nom = $data_personnel['nom'];
            }
            elseif(!$request->has('nom')){
                $this->nom = $data_personnel['nom'];
            }
            else{
                $this->nom = $data_['nom'];
            }



            if (self::matches($data_['date_naissance'],$data_personnel['date_naissance'])) {
                $this->date_naissance = $data_personnel['date_naissance'];
            }
            elseif(!$request->has('date_naissance')){
                $this->date_naissance = $data_personnel['date_naissance'];
            }
            else{
                $this->date_naissance = $data_['date_naissance'];
            }

            if (self::matches($data_['date_embauche'],$data_personnel['date_embauche'])) {
                $this->date_embauche = $data_personnel['date_embauche'];
            }
            elseif(!$request->has('date_embauche')){
                $this->date_embauche = $data_personnel['date_embauche'];
            }
            else{
                $this->date_embauche = $data_['date_embauche'];
            }


            if (self::matches($data_['matricule'],$data_personnel['matricule'])) {
                $this->matricule = $data_personnel['matricule'];
            }
            elseif(!$request->has('matricule')){
                $this->matricule = $data_personnel['matricule'];
            }
            else{
                $this->matricule = $data_['matricule'];
            }



            if (self::matches($data_['prenom'],$data_personnel['prenom'])) {
                $this->prenom = $data_personnel['prenom'];
            }
            elseif(!$request->has('prenom')){
                $this->prenom = $data_personnel['prenom'];
            }
            else{
                $this->prenom = $data_['prenom'];
            }

            if (self::matches($data_['sexe'],$data_personnel['sexe'])) {
                $this->sexe = $data_personnel['sexe'];
            }
            elseif(!$request->has('sexe')){
                $this->sexe = $data_personnel['sexe'];
            }
            else{
                $this->sexe = $data_['sexe'];
            }




            if (self::matches($data_['telephone'],$data_user['telephone'])) {
                $this->telephone = $data_user['telephone'];
            }
            elseif(!$request->has('telephone')){
                $this->telephone = $data_user['telephone'];
            }
            else{
                $this->telephone = $data_['telephone'];
            }



            if (self::matches($data_['langue'],$data_user['langue'])) {
                $this->langue = $data_user['langue'];
            }
            elseif(!$request->has('langue')){
                $this->langue = $data_user['langue'];
            }
            else{
                $this->langue = $data_['langue'];
            }

            if (self::matches($data_['email'],$data_user['email'])) {
                $this->email = $data_user['email'];
            }
            elseif(!$request->has('email')){
                $this->email = $data_user['email'];
            }
            else{
                $this->email = $data_['email'];
            }


            $this->role = $user->role;
            $this->password = $data_user['password'];
            $this->permissions = $data_user['permissions'];
            $this->last_login = $data_user['last_login'];
            $this->remember_token = $data_user['remember_token'];
            $this->slug_user = $data_user['slug'];


            $updatable_personnel = [
                "nom" => $this->nom,
                "prenom" => $this->prenom,
                "sexe" => $this->sexe,
                "matricule" => $this->matricule,
                "date_embauche" => $this->date_embauche,
                "slug" => str_randomize(10),
                "date_naissance" => $this->date_naissance,
                "created_at"	 => $this->created_at,
                "updated_at" => Carbon::now()->toDateTimeString(),
            ];

            $updatable_user = [
                "email"  => $this->email,
                "password"		 => $this->password,
                "permissions"	 => $this->permissions,
                "last_login"  => $this->last_login,
                "remember_token"	 => $this->remember_token,
                "slug"	 => str_randomize(10),
                "langue"		 => $this->langue,
                "telephone"		 => $this->telephone,
                "role"		 => $this->role,
                "created_at"	 => $this->created_at_,
                "updated_at" => Carbon::now()->toDateTimeString(),
            ];


            if ($user->update($updatable_user) && $personnel->update($updatable_personnel)) {
                return response()->json([
                    'content' => [
                        'message' => 'Compte mise à jours avec succès !',
                        'status'=>1,
                        'error' => null
                    ]
                ]);
            }
            return response()->json([
                'content' => [
                    'message' => 'Echec mise à jours recommencez svp !',
                    'status' => 0,
                    'error' => null
                ]
            ]);

        }

        return response()->json(['error' => 'Ce utilisateur n\'existe pas , vueillez recommencer!']);

    }
}