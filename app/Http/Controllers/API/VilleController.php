<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Ville as VilleResource;
use App\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   VilleController
|
|
|
|*/


class VilleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if(!VilleResource::collection(Ville::all())->isEmpty()){
            return response()->json(['content'=>VilleResource::collection(Ville::all()),'message'=>'liste des Villes'],200,['Content-Type'=>'application/json']);

        }
        return response()->json(['message'=>'Villes empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data =  [
            'nom' =>$request->nom,
            'pays' =>$request->pays,
         //   'decoupage_un' =>$request->decoupage_un,
            'slug'=>str_slug(name_generator('ville',10),'-')
        ];

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
                    'content'  => [
                        'error' => $validator->errors(),
                        'status' => $assert_false,
                        'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                    ]
                ]
            );
        }

        if (Ville::create($data)) {
            return response()->json([ 'content'  => [
                'error' => null,
                'status' => $assert_true,
                'message' => 'Ville enregistré avec succès !'
            ]],200,['Content-Type'=>'application/json']);

        }
        return response()->json([ 'content'  => [
            'error' => null,
            'status' => $assert_false,
            'message' => 'Echec enregistrement ville !']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function show(Request $request,$id)
    {
        if (Ville::where('id','=',$id)->first()){
            $ville = Ville::find($id);
            return response()->json(['content'=>new VilleResource($ville),'message'=>'détail Ville'],200,['Content-Type'=>'application/json']);
        }

        return response()->json(['message' => 'echec ,Ville n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    public function pays_ville($id_pays) {

        if(!Ville::where('pays', $id_pays)->get()->isEmpty()){

            fetchLog(Ville::class);
            return response()->json(
                ['content'=>Ville::where('pays', $id_pays)->get()
                    ,'message'=>'liste des Villes'],
                200, ['Content-Type'=>'application/json']);

        }
        return response()->json(['message' => ' Pas de ville pour ce pays !'],404,['Content-Type'=>'application/json']);

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
        if (Ville::where('slug','=',$slug)->first()){
            $ville = Ville::where('slug','=',$slug)->first();
            $data =  [
                'nom' =>$request->nom,
                'pays' =>$request->pays,
                'decoupage_un' =>$request->decoupage_un,
                'slug'=>str_slug(name_generator('ville',10),'-')
            ];

            if ($ville->update($data)){
                $ville =Ville::where('slug','=',$slug)->first();
                updateLog(Ville::class,$ville->id);
                return response()->json(['message' => ' Ville mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Ville::class,$ville->id);
                return response()->json(['message' => ' echec mise à jours Ville  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Ville::class,setZero());
        return response()->json(['message' => ' Ville n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Ville::where('slug','=',$slug)->first()){
            $ville = Ville::where('slug','=',$slug)->first();
            $ville->delete();
            return response()->json(['message' => ' Ville supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        return response()->json(['message' => ' Ville n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
