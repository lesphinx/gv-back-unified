<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use DB;
use Illuminate\Http\Request;
use Activation;
use Redirect;
use Session;
use Mail;
use Carbon\Carbon;
use Mailchimp;
use App\ZipCode;
use App\Http\Controllers\Controller;
use Auth;

use JWTAuth;

class AuthController extends Controller
{
    use  ThrottlesLogins;


    public function login(Request $request)
    {

        // Validation
        $validation = Validator::make(['email' => $request->email, 'password' => $request->password], [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Entrez une adresse email !',
            'email.email' => 'Entrez une adresse email valide !',
            'password.required' => 'Entrez votre mot de pass !',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);

        }

        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = \App\Role::where('id', $user->role)->first();


            if ($role->name === "Client") {
                $account = \App\Client::where('user_id', $user->id)->first();
            } elseif ($role->name === "Partenaire") {
                $account = \App\Partenaire::where('user_id', $user->id)->first();
            } else {
                return response()->json([
                    'errors' => 'Espace client et partenaire exclusivement !'
                ]);
            }

            try {
                // attempt to verify the credentials and create a token for the user
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
            }


            return response()->json([
                'token' => $token,
                'user' => $user,
                'compte' => $account,
                'user_role' => $role
            ], 200);
            error_log('message here.');
        }


    }




    protected function logout()
    {
        Sentinel::logout();
        return redirect('/');
    }

    protected function activate($id)
    {
        $user = Sentinel::findById($id);

        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $m = trans('messages.activation');
        Alert::info('Info', $m);


        return redirect('login');
    }


    public function register(Request $request)
    {


        $assert_false = 0;
        $assert_true = 1;


        $rules = [
            'nom' => 'required|string|min:2|max:100',
            'prenom' => 'required|string|min:2|max:100',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:100'

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
            'password.required' => 'Le champ password est obligatoire !',
            'password.string' => 'Le champ password doit contenir des chaines de charactères !',
            'password.min' => 'Le champ password doit contenir au moins six charactères !',
            'password.max' => 'Le champ password ne doit pas exceder 100 charactères !',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]);
        }

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'slug' => str_randomize(10),
            'email' => $request->email,
            'role' => \App\Role::where('name', 'Client')->first()->id,
            'password' => bcrypt($request->password)
        ];


        $data_user = [
            'email' => $data['email'],
            'password' => $data['password'],
            'slug' => $data['slug'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => $data['role']
        ];


        $user = User::create($data_user);

        if (User::where('slug', $data_user['slug'])->first()) {
            $user_ = User::where('slug', $data_user['slug'])->first();
            $data_ = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'slug' => str_randomize(10),
                'user_id' => $user_->id,
            ];

            \App\Client::create($data_);

            if ($user) {
                $user->roles()->sync([$data['role']]); // 2 = client
                return response()->json(['message' => 'Votre compte a été crée avec succès', 'status' => $assert_true]);
            }
            return response()->json(['error' => 'La création du compte client n\'est pas terminé, vueillé recommencer !',
                'status' => $assert_false]);
        }
        return response()->json(['error' => 'erreur creation client, recommencez svp !'
            , 'status' => $assert_false]);

    }
}
