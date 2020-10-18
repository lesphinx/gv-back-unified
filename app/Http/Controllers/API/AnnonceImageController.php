<?php

namespace App\Http\Controllers\API;
use Activation;
use App\Annonce;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileUpLoad;
use App\Http\Resources\Annonce as AnnonceResource;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   AnnonceController
|
|
|
|*/


class AnnonceImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($term = null)
    {
        if ($term != null) {
            $annoncesimage = AnnonceImage::where('titre', 'like', '%'.$term.'%')->get();
            return response()->json($annoncesimage, 200);
        }

        if(!AnnonceResource::collection(AnnonceImage::paginate(5))->isEmpty()){
            fetchLog(AnnonceImage::class);
            return response()->json([
                'content'=>AnnonceImage::orderBy('created_at','desc')->paginate(5),
                'message'=>'liste des Annonces'],
                200,
                ['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(AnnonceImage::class);
        return response()->json(['message'=>'Annonces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $assert_false = 0;
        $assert_true = 1;
        /**
         *
         *  Ici les champs à valider, soumit depuis la requette post
         */
        $rules = [
            'titre' => 'required|string|min:2|max:100',

        ];
        $messages = [
            'titre.required' => 'Le champ nom est obligatoire !',
            'titre.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'titre.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'titre.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'contenue.min' => 'Le champ contenue doit contenir au moins 30 charactères !',
            'image.image' => 'Choisissez une image',
            'image.mimes' => 'Choissiez un fichier de type jpeg, bmp ou png',
            'image.max' => 'L\'image ne doit pas dépasser 1 Mo',
            'contenue.string' => 'Le champ contenue doit contenir des chaines de charactères !',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        /**
         * Si le formulaire contient des erreur
         */
        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger svp!'
                ]
            );
        }


        /**
         * sinon le code continue par s'executer
         */


        if ($request->image != null) {
            $image_url = FileUpLoad::uf_base64($request->image, 'images');


            $data_image = [
                'nom' => $image_url,
                'alt'=>$image_url,
                'owner' => $request->partenaire,
                'slug'=>str_slug(name_generator('image',10),'-')
            ];

            /**
             * On crée l'agence principale
             */

            $new_image = Image::create($data_image);
            $var_image = $new_image->id;


        } else {
            $var_image = null;
        } // on attribue l'agence principale au partenaire'






        $data = [
            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'prix' => $request->prix,
            'nombreCaratere' => $request->nombreCaratere,
            'position' => $request->position,
            'etat' => $request->etat,
            'date_validation' => $request->date_validation,
            'utilisateur' => $request->utilisateur,
            'transaction' => $request->transaction,
            'image' => $var_image,
            'type_annonce' => $request->type_annonce,
            'partenaire' => $request->partenaire,
            'valider_par' => $request->valider_par,
            'slug' =>str_slug(name_generator('annonce',10),'-')
        ];


        if (AnnonceImage::create($data)) {
            createLog(AnnonceImage::class);
            return response()->json(['message' => ' AnnonceImage crée avec succès', 'status' => $assert_true], 200, ['Content-Type' => 'application/json']);

        }


        createFailureLog(AnnonceImage::class);
        return response()->json(['message'=>'echec de création AnnonceImage']);
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
        if (AnnonceImage::where('slug','=',$slug)->first()){
            $id = AnnonceImage::where('slug','=',$slug)->first()->id;
            showLog(AnnonceImage::class,$id);
            return response()->json(['content'=>new AnnonceResource(AnnonceImage::where('slug','=',$slug)->first()),'message'=>'détail AnnonceImage'],200,['Content-Type'=>'application/json']);
        }

        notFoundLog(AnnonceImage::class,setZero());
        return response()->json(['message' => 'echec ,AnnonceImage n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */


    public function update(Request $request,$slug)
    {
        if (AnnonceImage::where('slug','=',$slug)->first()){
            $annoncesimage = AnnonceImage::where('slug','=',$slug)->first();


            if ($request->titre != null) {
                $annoncesimage->titre = $request->titre;
            };

            if ($request->contenue != null) {
                $annoncesimage->contenue = $request->contenue;
            };
            if ($request->dateDebut != null) {
                $annoncesimage->dateDebut = $request->dateDebut;
            };




            if ($annoncesimage->update()){
                $annoncesimage =AnnonceImage::where('slug','=',$slug)->first();
                updateLog(AnnonceImage::class,$annoncesimage->id);
                return response()->json(['message' => ' AnnonceImage mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(AnnonceImage::class,$annoncesimage->id);
                return response()->json(['message' => ' echec mise à jours AnnonceImage  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(AnnonceImage::class,setZero());
        return response()->json(['message' => ' AnnonceImage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit(AnnonceImage $annoncesimage)
    {
        return response()->json($annoncesimage, 200);
    }



    public function destroy(Request $request,$slug)
    {

        if (AnnonceImage::where('slug','=',$slug)->first()){
            $annoncesimage = Annonce::where('slug','=',$slug)->first();
            $id=$annoncesimage->id;
            $annoncesimage->delete();
            deleteLog(Annonce::class,$id);
            return response()->json(['message' => ' Annonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Annonce::class,setZero());
        return response()->json(['message' => ' Annonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
