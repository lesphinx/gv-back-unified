<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\TypeChambre as TypeChambreResource;
use App\TypeChambre;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   TypeChambreController
|
|
|
|*/


class TypeChambreController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!TypeChambreResource::collection(TypeChambre::paginate(10))->isEmpty()){
                  return response()->json(['content'=>TypeChambreResource::collection(TypeChambre::all()),'message'=>'list of TypeChambres'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'TypeChambres empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (TypeChambre::create($request->all())) {
                return response()->json(['message' => ' TypeChambre stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store TypeChambre failed !']);
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
          if (TypeChambre::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new TypeChambreResource(TypeChambre::where('slug','=',$slug)->first()),'message'=>'detail TypeChambre'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,TypeChambre does not exist'],404,['Content-Type'=>'application/json']);
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
        if (TypeChambre::where('slug','=',$slug)->first()){
         $typechambre = TypeChambre::where('slug','=',$slug)->first();
         if ($typechambre->update($request->all())){
             $typechambre =TypeChambre::where('slug','=',$slug)->first();
             return response()->json(['message' => ' TypeChambre updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' TypeChambre does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (TypeChambre::where('slug','=',$slug)->first()){
                  $typechambre = TypeChambre::where('slug','=',$slug)->first();
                  $typechambre->delete();
                  return response()->json(['message' => ' TypeChambre deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' TypeChambre does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
