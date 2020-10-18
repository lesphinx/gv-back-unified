<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConnectedPersonnelResource;


class ConnectedUserController extends Controller
{
   public function getConnected(Request $request)
   {
       $connected_user_id = $request->id;

       return response()->json([
           'user' => [new ConnectedPersonnelResource(Personnel::where('id','=',$id)->first())]
       ]);
   }
}
