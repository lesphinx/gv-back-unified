<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Province as ProvinceResource;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ProvinceController
|
|
|
|*/


class ProvinceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ProvinceResource::collection(Province::all())->isEmpty()){
                   fetchLog(Province::class);
                    return response()->json(['content'=>ProvinceResource::collection(Province::all()),'message'=>'liste des Provinces'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Province::class);
                return response()->json(['message'=>'Provinces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'pays'=>$request->pays,'cheflieu'=>$request->cheflieu,'slug'=>str_slug(name_generator('decoupage-un',10),'-')];
        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2',
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
       if (Province::create($data)) {
              //   createLog(Province::class);
                  return response()->json(['message' => ' Province crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       //createFailureLog(Province::class);
       return response()->json(['message'=>'echec de création Province']);
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
            if (Province::where('slug','=',$slug)->first()){
            $id = Province::where('slug','=',$slug)->first()->id;
            showLog(Province::class,$id);
            return response()->json(['content'=>new ProvinceResource(Province::where('slug','=',$slug)->first()),'message'=>'détail Province'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Province::class,$id);
          return response()->json(['message' => 'echec ,Province n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
          if (Province::where('slug','=',$slug)->first()){
           $decoupageun = Province::where('slug','=',$slug)->first();
           $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'pays'=>$request->pays,'slug'=>str_slug(name_generator('decoupage-un',10),'-')];
           if ($decoupageun->update($data)){
               $decoupageun =Province::where('slug','=',$slug)->first();
               updateLog(Province::class,$decoupageun->id);
               return response()->json(['message' => ' Province mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Province::class,$decoupageun->id);
          return response()->json(['message' => ' echec mise à jours Province  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Province::class,setZero());
      return response()->json(['message' => ' Province n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Province::where('slug','=',$slug)->first()){
                    $decoupageun = Province::where('slug','=',$slug)->first();
                    $decoupageun->delete();
                    deleteLog(Province::class,$id);
                    return response()->json(['message' => ' Province supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Province::class,setZero());
        return response()->json(['message' => ' Province n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
