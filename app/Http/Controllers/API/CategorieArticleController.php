<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\CategorieArticle as CategorieArticleResource;
use App\CategorieArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CategorieArticleController
|
|
|
|*/


class CategorieArticleController extends Controller
{
    private static function matches($needle, $haystack)
    {
        if ($needle === $haystack) {
            return true;
        }
        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if (!CategorieArticleResource::collection(CategorieArticle::all())->isEmpty()) {
            // fetchLog(CategorieArticle::class);
            return response()->json(['content' => CategorieArticle::all(), 'message' => 'liste des CategorieArticles'], 200, ['Content-Type' => 'application/json']);

        }
        fetchEmptyLog(CategorieArticle::class);
        return response()->json(['message' => 'CategorieArticles empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
            'nom' => $request->nom,
            'description' => $request->description,
            'slug' => str_slug(name_generator('categorie-article', 10), '-'),
            'ajoute_par' => $request->ajoute_par
        ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2|max:100',
            'description' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'description.required' => 'Le champ description est obligatoire !',
            'description.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description.min' => 'Le champ description doit contenir au moins deux charactères !',
            'description.max' => 'Le champ description ne doit pas exceder 100 charactères !',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'content' => [
                        'error' => $validator->errors(),
                        'status' => 0,
                        'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                    ]
                ]
            );
        }


        if (CategorieArticle::create($data)) {
            // createLog(CategorieArticle::class);
            return response()->json(
                [
                    'content' => [
                        'error' => null,
                        'status' => 1,
                        'message' => 'Catégorie enregistré avec succès !'
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
     * @param string $slug
     *
     * @return Response
     */
    public function show(Request $request, $slug)
    {
        if (CategorieArticle::where('slug', '=', $slug)->first()) {
            $id = CategorieArticle::where('slug', '=', $slug)->first()->id;
            showLog(CategorieArticle::class, $id);
            return response()->json(['content' => new CategorieArticleResource(CategorieArticle::where('slug', '=', $slug)->first()), 'message' => 'détail CategorieArticle'], 200, ['Content-Type' => 'application/json']);
        }

        notFoundLog(CategorieArticle::class, setZero());
        return response()->json(['message' => 'echec ,CategorieArticle n\existe pas'], 404, ['Content-Type' => 'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function update(Request $request, $slug)
    {
        $nom = '';
        $description = '';

        if (CategorieArticle::where('slug', '=', $slug)->first()) {
            $categoriearticle = CategorieArticle::where('slug', '=', $slug)->first();

            $rules = [
                'nom' => 'required|string|min:2|max:100',
                'description' => 'required|string|min:2|max:1000',

            ];

            $messages = [
                'nom.required' => 'Le champ nom est obligatoire !',
                'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
                'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
                'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
                'description.required' => 'Le champ description est obligatoire !',
                'description.string' => 'Le champ description doit contenir des chaines de charactères !',
                'description.min' => 'Le champ description doit contenir au moins deux charactères !',
                'description.max' => 'Le champ description ne doit pas exceder 1000 charactères !',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'content' => [
                            'error' => $validator->errors(),
                            'status' => 0,
                            'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                        ]
                    ]
                );
            }

            $data = [
                'nom' => $request->nom,
                'description' => $request->description,
                'slug' => $request->slug
            ];

            $data_old = [
                'nom' =>$categoriearticle->nom,
                'description' =>$categoriearticle->description,
            ];


            if (self::matches($data['nom'],$data_old['nom'])){
                $nom = $data_old['nom'];
            }else{
                $nom = $data['nom'];
            }
            if (self::matches($data['description'],$data_old['description'])){
                $description = $data_old['description'];
            }else{
                $description = $data['description'];
            }

            $updatable = [
                'nom' =>$nom,
                'description' =>$description,
            ];

            if ($categoriearticle->update($updatable)) {
                $categoriearticle = CategorieArticle::where('slug', '=', $slug)->first();
                //updateLog(CategorieArticle::class,$categoriearticle->id);
                return response()->json(
                    [
                        'content' => [
                            'error' => null,
                            'status' => 1,
                            'message' => 'Mise à jours effectué avec succès !'
                        ]
                    ]
                );
            } else {
                // updateFailureLog(CategorieArticle::class,$categoriearticle->id);
                return response()->json(
                    [
                        'content' => [
                            'error' => null,
                            'status' => 0,
                            'message' => 'Echec de Mise à jours de la catégorie !'
                        ]
                    ]
                );
            }

        }

        //notFoundLog(CategorieArticle::class,setZero());
        return response()->json(
            [
                'content' => [
                    'error' => null,
                    'status' => 0,
                    'message' => 'La catégorie que vous essayer de modifier n\'existe pas !'
                ]
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (CategorieArticle::where('slug', '=', $slug)->first()) {
            $categoriearticle = CategorieArticle::where('slug', '=', $slug)->first();
            $categoriearticle->delete();
            deleteLog(CategorieArticle::class, $categoriearticle->id);
            return response()->json(['message' => ' CategorieArticle supprimé avec succès'], 200, ['Content-Type' => 'application/json']);
        }

        deleteFailureLog(CategorieArticle::class, setZero());
        return response()->json(['message' => ' CategorieArticle n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
    }


}
