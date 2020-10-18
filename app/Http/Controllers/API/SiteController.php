<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FileUpLoad;
use App\Http\Resources\Site as SiteResource;
use App\Http\Resources\Voyage as VoyageResource;
use App\Image;
use App\Site;
use App\SiteImage;
use App\Partenaire;
use App\Voyage;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   SiteController
|
|
|
|*/


class SiteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $client = $request->input('client');
        if($client == 1) {
            if(!Site::all()->isEmpty()){
                fetchLog(Site::class);
                return response()->json([
                    'content'=>Site::with('getPartenaire', 'getVille', 'images')
                        ->orderBy('created_at','desc')
                        ->where('etat', '=', '3')
                        ->paginate(500),
                    'message'=>'liste des Sites'],
                    200,['Content-Type'=>'application/json']);

            }
        } else {
            if(!Site::all()->isEmpty()){
                fetchLog(Site::class);
                return response()->json([
                    'content'=>Site::with('getProvice', 'images')
                        ->orderBy('created_at','desc')
                        ->paginate(500),
                    'message'=>'liste des Sites'],
                    200,['Content-Type'=>'application/json']);

            }
        }
        fetchEmptyLog(Site::class);
        return response()->json(['message'=>'Sites empty']);

    }


    public function getSites()
    {
      return response()->json(['_embeded'=> new SiteResource(Site::orderBy('id','desc')->paginate(9)), 'message'=>'Liste des voyages'], 200);

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
           'province' => $request->province,
           'description'=>$request->description,
           'slug' => 'site-'.str_randomize(20)
       ];


        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2',
            'description'=>'string|min:30|nullable',
            'province' => 'required',

        ];

        $messages = [
            'province.required' => 'Vous devez choisir une province',
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'description.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description.min' => 'Le champ description doit contenir au moins 30 charactères !',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }
       if (Site::create($data)) {

           $site_created = Site::where('slug', '=' , $data['slug'])->first();

           // On enregistres les images
           foreach($request->photos as $p) {
               $image_url = FileUpLoad::uf_base64($p, 'sites');
               $new_image = Image::create([
                   'nom' => $image_url,
                   'owner' => $request->partenaire,
                   'slug' => str_randomize(20)
               ]);

               SiteImage::create([
                  'site' => $site_created->id,
                  'image' => $new_image->id,
                  'slug' => str_randomize(20)
               ]);
           }
           createLog(Site::class);
          return response()->json(['message' => ' Site crée avec succès'],200,['Content-Type'=>'application/json']);
       }
       createFailureLog( Site::class);
       return response()->json(['message'=>'echec de création Site']);
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
            if (Site::where('slug','=',$slug)->first()){
            $id = Site::where('slug','=',$slug)->first()->id;
            showLog(Site::class,$id);
            return response()->json(['content'=>new SiteResource(Site::where('slug','=',$slug)->first()),'message'=>'détail Site'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Site::class, $slug);
          return response()->json(['message' => 'echec ,Site n\existe pas'],404,['Content-Type'=>'application/json']);
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
        $site = Site::where('slug','=',$slug)->first();
        if ($site) {

           $site->nom = $request->nom;
           $site->partenaire = $request->partenaire;
           $site->description = $request->description;
           $site->date_debut_disponibilite =$request->date_debut;
           $site->prix_jour =$request->prix_jour;
           $site->date_fin_disponibilite =$request->date_fin;

           if ($request->province != null ) {
               $site->province = $request->province;
           }

           if ($request->photos ) {
               // On enregistres les images
               foreach($request->photos as $p) {
                   $image_url = FileUpLoad::uf_base64($p, 'sites');
                   $new_image = Image::create([
                       'nom' => $image_url,
                       'owner' => $request->partenaire,
                       'slug' => str_randomize(20)
                   ]);

                   SiteImage::create([
                       'site' => $site->id,
                       'image' => $new_image->id,
                       'slug' => str_randomize(20)
                   ]);
               }
           }

            // On supprime les images
            if ($request->image_to_remove) {
                foreach($request->image_to_remove as $p) {
                    $image_site = SiteImage::where('image', '=', $p)
                        ->where('site' , '=', $site->id)
                        ->first();
                    $image_site->delete();

                }
            }

           if ($site->update()) {
              updateLog(Site::class,$site->id);
               return response()->json(['message' => ' Site mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           } else {
              updateFailureLog(Site::class,$site->id);
              return response()->json(['message' => ' echec mise à jours Site  !'],400,['Content-Type'=>'application/json']);
           }
        }

        notFoundLog(Site::class,setZero());
        return response()->json(['message' => ' Site n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Site::where('slug','=',$slug)->first()){
                    $site = Site::where('slug','=',$slug)->first();
                    $id = $site->id;
                    $site->delete();
                    deleteLog(Site::class,$id);
                    return response()->json(['message' => ' Site supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Site::class,setZero());
        return response()->json(['message' => ' Site n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }




    /**
     * La function qui permet de changer l'etat d'un voyage dans la base de données
     */
    public function change_state($slug) {

        $site = Site::where('slug','=',$slug)->first();

        if($site != null) {
            if($site->etat == 4) {
                $site->etat = 3;
            }else {
                $site->etat ++;
            }

            $site->update();
            updateLog(Site::class, $site->id);
            return response()->json([
                'message' => 'Etat changé avec succès'
            ],200,['Content-Type'=>'application/json']);
        }
        notFoundLog(Site::class, setZero());
        return response()->json([
            'message' => 'Site non trouvé'
        ],404,['Content-Type'=>'application/json']);
    }


    public function min_max_price() {
        $max_price = Site::where('etat', '=' , '3')->max('prix_jour');
        $min_price = Site::where('etat', '=' , '3')->min('prix_jour');


        return response()->json([
            'min' => $min_price,
            'max' => $max_price
        ]);

    }
}
