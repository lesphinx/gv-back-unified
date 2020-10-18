<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\MessageContact as MessageContactResource;
use App\MessageContact;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   MessageContactController
|
|
|
|*/


class MessageContactController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!MessageContactResource::collection(MessageContact::paginate(10))->isEmpty()){
                  return response()->json(['content'=>MessageContact::orderBy('created_at','desc')->paginate(10),'message'=>'list of MessageContacts'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'MessageContacts empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (MessageContact::create($request->all())) {
                return response()->json(['message' => 'Nous avons reçu votre message ! Consulter votre boite email, nous vous contacterons sur votre adresse : '.$request->email],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store MessageContact failed !']);
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
          if (MessageContact::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new MessageContactResource(MessageContact::where('slug','=',$slug)->first()),'message'=>'detail MessageContact'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,MessageContact does not exist'],404,['Content-Type'=>'application/json']);
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
        if (MessageContact::where('slug','=',$slug)->first()){
         $messagecontact = MessageContact::where('slug','=',$slug)->first();
         if ($messagecontact->update($request->all())){
             $messagecontact =MessageContact::where('slug','=',$slug)->first();
             return response()->json(['message' => ' MessageContact updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' MessageContact does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (MessageContact::where('slug','=',$slug)->first()){
                  $messagecontact = MessageContact::where('slug','=',$slug)->first();
                  $messagecontact->delete();
                  return response()->json(['message' => ' MessageContact deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' MessageContact does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
