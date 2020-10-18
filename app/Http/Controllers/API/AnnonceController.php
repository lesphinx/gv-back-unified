<?php

namespace App\Http\Controllers\API;
use Activation;
use App\Annonce;
use App\AnnonceImage;
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


class AnnonceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($term = null)
    {
        if ($term != null) {
            $annonce = Annonce::where('titre', 'like', '%'.$term.'%')->get();
            return response()->json($annonce, 200);
        }

        if(!AnnonceResource::collection(Annonce::paginate(5))->isEmpty()){
            fetchLog(Annonce::class);
            return response()->json([
                'content'=>Annonce::with('images')->orderBy('created_at','desc')->paginate(200),
                'message'=>'liste des Annonces'],
                200,
                ['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(Annonce::class);
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
            'contenue'=>'string|min:3|nullable'

        ];
        $messages = [
            'titre.required' => 'Le champ titre est obligatoire !',
            'titre.string' => 'Le champ titre doit contenir des chaines de charactères !',
            'titre.min' => 'Le champ titre doit contenir au moins deux charactères !',
            'titre.max' => 'Le champ titre ne doit pas exceder 100 charactères !',
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

        $data = [

            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'contact' => $request->contact,
            'annonceur' => $request->annonceur,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'prix' => $request->prix,
            'nombreCaratere' => $request->nombreCaratere,
            'position' => $request->position,
            'etat' => 1,
            'date_validation' => null,
            'utilisateur' => $request->utilisateur,
            'bloquerPour' => $request->bloquerPour,
            'transaction' => $request->transaction,
            'image' => $request->image,
            //'image' => $var_image,
            'type_annonce' => $request->type_annonce,
            'partenaire' => $request->partenaire,
            'valider_par' => $request->valider_par,
            'slug' =>str_slug(name_generator('annonce',10),'-')
        ];
        $new_annonce=Annonce::create($data);
        $var_annonce = $new_annonce->id;

        if($request->images != null)
        {
            foreach ($request->images as $img )

            {
                // dd($img['path']);
                if ($img != null) {
                    $image_url = FileUpLoad::uf_base64($img['path'], 'annonces');


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


                }
                if ($var_image && $var_annonce){

                    $data_img_a = [
                        'desc' => $image_url,
                        'image' => $var_image,
                        'annonce' => $var_annonce,
                        'slug'=>str_slug(name_generator('image_annonce',10),'-')
                    ];
                    $new_image_annonce = AnnonceImage::create($data_img_a);

                }


            }
        }


        /**
         * sinon le code continue par s'executer
         */


       else if ($request->image != null) {
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
            $var_image1 = $new_image->id;


           if ($var_image1 && $var_annonce){

               $data_img_a = [
                   'desc' => $image_url,
                   'image' => $var_image1,
                   'annonce' => $var_annonce,
                   'slug'=>str_slug(name_generator('image_annonce',10),'-')
               ];
               $new_image_annonce = AnnonceImage::create($data_img_a);


           }



        }






        if ($new_annonce) {
            createLog(Annonce::class);
            return response()->json(['message' => ' Annonce crée avec succès', 'status' => $assert_true],
                200,
                ['Content-Type' => 'application/json']);

        }


        createFailureLog(Annonce::class);
        return response()->json(['message'=>'echec de création Annonce']);
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
        if (Annonce::where('slug','=',$slug)->first()){
            $id = Annonce::where('slug','=',$slug)->first()->id;
            showLog(Annonce::class,$id);
            return response()->json(['content'=>new AnnonceResource(Annonce::where('slug','=',$slug)->first()),'message'=>'détail Annonce'],200,['Content-Type'=>'application/json']);
        }

        notFoundLog(Annonce::class,setZero());
        return response()->json(['message' => 'echec ,Annonce n\existe pas'],404,['Content-Type'=>'application/json']);
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
        $annonce = Annonce::where('slug','=',$slug)->first();
        if ($annonce){
            $image = Image::where('id' , '=' , $request->images)->first();




            if ($request->titre != null) {
                $annonce->titre = $request->titre;
            };
             if ($request->etat != null) {
                $annonce->etat = $request->etat;
            };
            if ($request->contenue != null) {
                $annonce->contenue = $request->contenue;
            };
            if ($request->contact != null) {
                $annonce->contact = $request->contact;
            };
            if ($request->annonceur != null) {
                $annonce->annonceur = $request->annonceur;
            };
          

            if ($annonce->update()){
                $annonce =Annonce::where('slug','=',$slug)->first();
                updateLog(Annonce::class,$annonce->id);
                return response()->json(['message' => ' Annonce mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Annonce::class,$annonce->id);
                return response()->json(['message' => ' echec mise à jours Annonce  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Annonce::class,setZero());
        return response()->json(['message' => ' Annonce n\'existe pas !'],
            404,
            ['Content-Type'=>'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit(Annonce $annonce)
    {
        return response()->json($annonce, 200);
    }



    public function destroy(Request $request,$slug)
    {

        if (Annonce::where('slug','=',$slug)->first()){
            $annonce = Annonce::where('slug','=',$slug)->first();
            $id=$annonce->id;
            $annonce->delete();
            deleteLog(Annonce::class,$id);
            return response()->json(['message' => ' Annonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Annonce::class,setZero());
        return response()->json(['message' => ' Annonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


    /**
     * La function qui permet de changer l'etat d'une annonce dans la base de données
     */
    public function change_state($slug) {

        $annonce = Annonce::where('slug','=',$slug)->first();

        if($annonce != null) {
            if($annonce->etat == 4) {
                $annonce->etat = 3;
            }else {
                $annonce->etat ++;
            }

            $annonce->update();
            updateLog(Voyage::class, $annonce->id);
            return response()->json([
                'message' => 'Etat changé avec succès'
            ],200,['Content-Type'=>'application/json']);
        }
        notFoundLog(Annonce::class, setZero());
        return response()->json([
            'message' => 'Annonce non trouvé'
        ],404,['Content-Type'=>'application/json']);
    }


}
