<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function reset(Request $request)
    {

        
        if (User::where('slug',$request->slug)->first()) {
            $user = User::where('slug',$request->slug)->first();

         $data_ = [
            'email' => $user->email,
            'role' => $user->role,
            'telephone' => $user->telephone,
            'langue' => $user->langue,
            'slug' => $user->slug,
            'permissions'=> $user->permissions,
            'last_login' => $user->last_login,
            'password' => Hash::make('gvoyage@2019'),
            'created_at'=> $user->created_at,
            'remember_token' => $user->remember_token,
            'updated_at'=> Carbon::now()->toDateTimeString()

        ];
        
         if ($user->update($data_)) {
            return response()->json(['message' => 'Mot de pass mise à jours avec succès']);
          }
          return response()->json(['error' =>  'Echec mise à jours mot de pass !']);

        }
        return response()->json(['error' => 'Echec mise à jours mot de pass ,l\'utilisateur n\'existe pas!']);


    }

}
