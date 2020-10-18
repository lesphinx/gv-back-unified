<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Hotel as HotelResource;
use App\Hotel;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   HotelController
|
|
|
|*/


class HotelController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!HotelResource::collection(Hotel::paginate(10))->isEmpty()){
                  return response()->json(['content'=>HotelResource::collection(Hotel::all()),'message'=>'list of Hotels'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Hotels empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $data = [
        'nom' =>$request->nom,
        'description'=>$request->description,
        'image'=>$request->image,
        'slug'=>str_slug(name_generator('type-chambre',30),'-'),

      ];

      $assert_false = 0;
      $assert_true = 1;

      $rules = [
          'nom' => 'required|string|min:2',
          'description' => 'required|string|min:2',
      ];

      $messages = [
          'nom.required' => 'Le champ nom est obligatoire !',
          'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
          'nom.min' => 'Le champ nom doit contenir au moins deux charactères !'

      ];

      $validator = Validator::make($request->all(), $rules,$messages);

      if ($validator->fails()) {
          return response()->json(
              [
                  'error' => $validator->errors(),
                  'status' => $assert_false,
                  'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
              ]
          );
      }

     if (Hotel::create($data)) {
       return response()->json(
                   [
                       'content' => [
                           'error' => null,
                           'status' => 1,
                           'message' => 'Type Chambre enregistré avec succès !'
                       ]
                   ]
               );

            }


            return response()->json(
                [
                    'content' => [
                        'error' => null,
                        'status' => 0,
                        'message' => 'Echec de création catégorie !'
                    ]
                ]
            );
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return Response
   */
  public function show(Request $request,$slug)
   {
          if (Hotel::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new HotelResource(Hotel::where('slug','=',$slug)->first()),'message'=>'detail Hotel'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Hotel does not exist'],404,['Content-Type'=>'application/json']);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function update(Request $request)
  {
        if (Hotel::where('slug','=',$slug)->first()){
         $hotel = Hotel::where('slug','=',$slug)->first();
         if ($hotel->update($request->all())){
             $hotel =Hotel::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Hotel updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Hotel does not exist !'],404,['Content-Type'=>'application/json']);
   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function destroy(Request $request,$slug)
   {
            if (Hotel::where('slug','=',$slug)->first()){
                  $hotel = Hotel::where('slug','=',$slug)->first();
                  $hotel->delete();
                  return response()->json(['message' => ' Hotel deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Hotel does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
