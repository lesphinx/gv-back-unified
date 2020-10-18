<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Personnel as PersonnelResource;
use App\Personnel;

use App\Role;

use App\User;
use App\Utilisateur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//use App\Logger\Logger;
use Sentinel;
use Activation;
use Illuminate\Validation\Rule;
use ipinfo\ipinfo\IPinfo;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PersonnelController
|
|
|
|*/


class PersonnelController extends Controller
{
    private $nom;
    private $prenom;
    private $sexe;
    private $email;
    private $role;
    private $telephone;
    private $langue;
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $personnels = Personnel::all();
        $roles = Role::where('name', '<>', 'client')
            ->where('name', '<>', 'Admin')
            ->where('name', '<>', 'admins')
            ->where('name', '<>', 'admin')
            ->where('name', '<>', 'Admins')
            ->where('name', '<>', 'Partenaire')
            ->where('name', '<>', 'Partenaires')
            ->where('name', '<>', 'administrateur')
            ->where('name', '<>', 'administrateurs')
            ->where('name', '<>', 'Administrateur')
            ->where('name', '<>', 'Administrateurs')
            ->where('name', '<>', 'Client')
            ->where('name', '<>', 'Clients')
            ->where('name', '<>', 'clients')
            ->where('name', '<>', 'client')
            ->get();
        if (!PersonnelResource::collection($personnels)->isEmpty()) {
            //Logger::fetchLog(Personnel::class);
            return response()->json(
                [
                    'content' => [
                        'personnels' =>PersonnelResource::collection($personnels),
                        'roles' => $roles,
                    ]
                ],
                200,
                ['Content-Type' => 'application/json']
            );
        }
        //Logger::fetchEmptyLog(Personnel::class);
        return response()->json(['content' => [
            'message' => 'Liste vide',
            'roles' => $roles,
        ]]);

    }


    public function show(Request $request,$slug)
    {
        if (Personnel::where('slug','=',$slug)->first()){
            $personnel = Personnel::where('slug','=',$slug)->first();
            //Logger::showLog(Personnel::class,$personnel->id);
            return response()->json(['content'=>new PersonnelResource(Personnel::where('slug','=',$slug)->first()),'message'=>'detail Personnel'],200,['Content-Type'=>'application/json']);
        }
        //Logger::showFailureLog(Personnel::class,0);

        return response()->json(['message' => 'echec ,Personnel does not exist'],404,['Content-Type'=>'application/json']);
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

        $data = [
            'matricule' => $request->matricule,
            'date_embauche' => $request->date_embauche,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'slug' => str_randomize(10),
            'email' => $request->email,
            'role' => $request->role,
            'telephone' => $request->telephone,
            'langue' => $request->langue,
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance
        ];
        $dt = Carbon::now();

        $rules = [
            'nom' => 'required|string|min:2|max:100',
            'prenom' => 'required|string|min:2|max:100',
            'matricule' => 'required|string|min:2|max:8|unique:personnels',
            'date_embauche' => 'required|date|before_or_equal:'.$dt,
            'email' => 'required|string|email|unique:users',
            'date_naissance' => 'date|before_or_equal:'.$dt,
            'role' => 'required'

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'matricule.required' => 'Le champ matricule est obligatoire !',
            'date_embauche.required' => 'Le champ date embauche est obligatoire !',
            'matricule.unique' => 'Ce matricule est déja occupé !',
            'email.unique' => 'Cette adresse email est déja occupé !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'prenom.required' => 'Le champ prenom est obligatoire !',
            'prenom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'prenom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'prenom.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
            'email.required' => 'Le champ  email est obligatoire ! ',
            'email.email' => 'L\'adresse email est invalide',
            'date_naissance.date' => 'La date de naissance est invalide',
            'date_naissance.before_or_equal' => 'La date de naissance doit etre la date du jours ou une date entérieure ! ',
            'date_embauche.date' => 'La date d\'embauche est invalide',
            'date_embauche.before_or_equal' => 'La date d\'embauche doit etre la date du jours ou une date entérieure ! ',
            'role.required' => 'Attribuer un role SVP !'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'content' => [
                        'error' => $validator->errors(),
                        'status' => $assert_false,
                        'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                    ]
                ]
            );
        }

        $data_user = [
            'matricule' => $data['matricule'],
            'date_embauche' => $data['date_embauche'],
            'email' => $data['email'],
            'password' => Hash::make('default-for-admin-only'),
            'slug' => $data['slug'],
            'langue' => $data['langue'],
            'telephone' => $data['telephone'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => (integer)$data['role']
        ];


        $user = User::create($data_user);

        if (User::where('slug', $data_user['slug'])->first()) {
            $user_ = User::where('slug', $data_user['slug'])->first();
            $role_ = $user_->role;
            $data_ = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'sexe' => $data['sexe'],
                'matricule' => $data['matricule'],
                'date_embauche' => $data['date_embauche'],
                'slug' => str_randomize(10),
                'user_id' => $user_->id,
                'date_naissance' => $data['date_naissance']
            ];

            Personnel::create($data_);
            createLog(Personnel::class);
            if ($user) {
                $user->roles()->sync([$role_]);
                return response()->json(
                    [
                        'content' => [
                            'error' => null,
                            'status' => 1,
                            'message' => 'Personnel enregistré avec succès !'
                        ]
                    ]
                );
            }

            createFailureLog(Personnel::class);
            return response()->json(
                [
                    'error' => 'La création du compte personnel n\'est pas terminé, vueillé recommencer !',
                    'status' => $assert_false
                ]);
        }
        return response()->json(['error' => 'erreur creation personnel, recommencez svp !', 'status' => $assert_false]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (User::where('slug', '=', $slug)->first()) {
            $user = User::where('slug', '=', $slug)->first();
            $role = Role::where('id', '=', $user->role)->first();
            $personel_slug = $user->getAffiliatePersonnel->slug;
            $personel = Personnel::where('slug', $personel_slug)->first();
            if ($user->delete() && $personel->delete()) {
                deleteLog(Personnel::class,$user->getAffiliatePersonnel->id);
                return response()->json(['message' => ' !!! Ce utilisateur a ete suprrimé avec succès !!!'], 200, ['Content-Type' => 'application/json']);
            }

            deleteLog(Personnel::class,0);
            return response()->json(['message' => 'Erreur de suppression recommencer']);

        }

        deleteFailureLog(Personnel::class, setZero());
        return response()->json(['message' => ' !!! Client n\'existe pas !!!'], 404, ['Content-Type' => 'application/json']);
    }


    public function activation(Request $request, $id)
    {

        $user = User::where('slug', $id)->first();
        $activation = Activation::completed($user);
        if ($activation) {
            return response()->json(['message' => 'Ce compte est déja activé']);
        }
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $role = $user->roles()->first()->name;
        return response()->json(['message' => 'Compte activé avec succès !']);
    }

    public function deactivation(Request $request, $id)
    {
        $user = User::where('slug', $id)->first();
        Activation::remove($user);
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);

    }

    public function changeRole(Request $request, $slug)
    {
        if (User::where('slug', '=', $slug)->first()) {
            $get_role = Role::find($request->input('id'));
            $rule = $get_role->id;

            $rules = [
                'id' => ['required',
                    'string',
                    Rule::exists('roles')->where(function ($query) {
                        $query->where('name', '<>', 'Admin')
                            ->where('name', '<>', 'admins')
                            ->where('name', '<>', 'admin')
                            ->where('name', '<>', 'Admins')
                            ->where('name', '<>', 'Partenaire')
                            ->where('name', '<>', 'Partenaires')
                            ->where('name', '<>', 'administrateur')
                            ->where('name', '<>', 'administrateurs')
                            ->where('name', '<>', 'Administrateur')
                            ->where('name', '<>', 'Administrateurs')
                            ->where('name', '<>', 'Client')
                            ->where('name', '<>', 'Clients')
                            ->where('name', '<>', 'clients')
                            ->where('name', '<>', 'client');
                    })
                ]

            ];

            $messages = [
                'id.string' => 'le role est invalide',
                'id.required' => 'Le role est obligatoire',
                'id.exists' => 'Le role choisit est irrecevable',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'content' => [
                        'status' => 0,
                        'error' => $validator->errors()

                    ],
                ]);
            }


            $user = User::where('slug', '=', $slug)->first();
            $role = Role::find($request->input('id'));

            $data_ = [
                'role' => $rule,
            ];

            $data_user = [
                'email' => $user->email,
                'role' => $user->role,
                'telephone' => $user->telephone,
                'langue' => $user->langue,
                'password' => $user->password,
                "permissions" => $user->permissions,
                "last_login" => $user->last_login,
                "remember_token" => $user->remember_token,
                "slug" => $user->slug_client,
                "langue" => $user->langue,
                "telephone" => $user->telephone,
                "role" => $user->role,
                "created_at" => $user->created_at,
            ];

            $role_id = $role->id;

            if (self::matches($data_['role'], $data_user['role'])) {
                $this->role = $data_user['role'];
            } else {
                $this->role = $role_id;
            }


            $this->telephone = $data_user['telephone'];
            $this->langue = $data_user['langue'];
            $this->email = $data_user['email'];


            $this->password = $data_user['password'];
            $this->permissions = $data_user['permissions'];
            $this->last_login = $data_user['last_login'];
            $this->remember_token = $data_user['remember_token'];
            $this->slug_user = $data_user['slug'];
            $updatable_user = [
                "email" => $this->email,
                "password" => $this->password,
                "permissions" => $this->permissions,
                "last_login" => $this->last_login,
                "remember_token" => $this->remember_token,
                "slug" => $user->slug,
                "langue" => $this->langue,
                "telephone" => $this->telephone,
                "role" => $this->role,
                "created_at" => $this->created_at_,
                "updated_at" => Carbon::now()->toDateTimeString(),
            ];

            if ($user->update($updatable_user)) {
                return response()->json([
                    'content' => [
                        'status' => 1,
                        'message' => 'Le role utilisateur mise à jours avec succès !'
                    ]
                ]);
            }
            return response()->json([
                'content' => [
                    'status' => 1,
                    'error' => 'Echec de modification role utilisateur !'
                ]
            ]);

        }

        return response()->json([
            'content' => [
                'status' => 1,
                'error' => 'Echec de modification , utilisateur n\'a pas été trouvé !'
            ]
        ]);

    }


}