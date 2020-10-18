<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Chambre as ChambreResource;
use App\Chambre;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ChambreController
|
|
|
|*/


class ChambreController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!ChambreResource::collection(Chambre::paginate(10))->isEmpty()){
                  return response()->json(['content'=>ChambreResource::collection(Chambre::all()),'message'=>'list of Chambres'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Chambres empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Chambre::create($request->all())) {
                return response()->json(['message' => ' Chambre stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Chambre failed !']);
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
          if (Chambre::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new ChambreResource(Chambre::where('slug','=',$slug)->first()),'message'=>'detail Chambre'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Chambre does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Chambre::where('slug','=',$slug)->first()){
         $chambre = Chambre:::where('slug','=',$slug)->first();
         if ($chambre->update($request->all())){
             $chambre =Chambre::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Chambre updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Chambre does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Chambre::where('slug','=',$slug)->first()){
                  $chambre = Chambre::where('slug','=',$slug)->first();
                  $chambre->delete();
                  return response()->json(['message' => ' Chambre deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Chambre does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
