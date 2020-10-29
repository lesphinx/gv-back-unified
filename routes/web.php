<?php


Route::auth();
Route::get('/', ['uses' => 'HomeController@home']);
Route::get('permission', 'AdminDashboardController@nopermission')->name('need-permission');
Route::get('/permission', 'AdminDashboardController@nopermission')->name('permission');



Route::group(['middleware' => ['web', 'auth', 'permission']], function () {
    Route::get('dashboard', ['uses' => 'HomeController@dashboard', 'as' => 'home.dashboard']);

    Route::get('token', 'Auth\\LoginController@getAccessToken')->name('web-api.getAccessToken');

    //users
    Route::resource('user', 'UserController');
    Route::get('user/{user}/permissions', ['uses' => 'UserController@permissions', 'as' => 'user.permissions']);
    Route::post('user/{user}/save', ['uses' => 'UserController@save', 'as' => 'user.save']);
    Route::get('user/{user}/activate', ['uses' => 'UserController@activate', 'as' => 'user.activate']);
    Route::get('user/{user}/deactivate', ['uses' => 'UserController@deactivate', 'as' => 'user.deactivate']);
    Route::post('user/ajax_all', ['uses' => 'UserController@ajax_all']);
    //roles
    Route::resource('role', 'RoleController');
    Route::get('role/{role}/permissions', ['uses' => 'RoleController@permissions', 'as' => 'role.permissions']);
    Route::post('role/{role}/save', ['uses' => 'RoleController@save', 'as' => 'role.save']);
    Route::post('role/check', ['uses' => 'RoleController@check']);

    //user administrations
    Route::get('clients', 'AdminDashboardController@client')->name('pages.client');
    Route::get('admins', 'AdminDashboardController@admin')->name('pages.admin');
    Route::get('personnels', 'AdminDashboardController@personnel')->name('pages.personnel');
    Route::get('partenaires', 'AdminDashboardController@partenaire')->name('pages.partenaire');
    Route::get('getroles', 'RoleController@index')->name('pages.getroles');

    // agence
    Route::get('agences', 'AdminDashboardController@agence')->name('pages.agence');
    // agence
    Route::get('annonces', 'AdminDashboardController@annonce')->name('pages.annonce');
    Route::get('publicites', 'AdminDashboardController@publicite')->name('pages.publicite');

    // billet
    Route::get('billets', 'AdminDashboardController@billet')->name('pages.billet');
    // Article
    Route::get('articles', 'AdminDashboardController@article')->name('pages.article');
    // Classe
    Route::get('classes', 'AdminDashboardController@classe')->name('pages.classe');
    // categorie Article
    Route::get('categories', 'AdminDashboardController@categorie')->name('pages.categorie');
    // commentaires
    Route::get('commentaires', 'AdminDashboardController@commentaire')->name('pages.commentaire');
    // Decoupage Deux
    Route::get('decoupagedeus', 'AdminDashboardController@decoupagedeux')->name('pages.decoupage-deux');
    // Decoupage Trois
    Route::get('decoupagetroix', 'AdminDashboardController@decoupagetrois')->name('pages.decoupage-trois');
    // Decoupage un
    Route::get('decoupageuns', 'AdminDashboardController@decoupageun')->name('pages.decoupage-un');
    // Demande partenariat
    Route::get('demandes', 'AdminDashboardController@demande')->name('pages.demande');
    // Facturationd
    Route::get('facturations', 'AdminDashboardController@facturation')->name('pages.facturation');

    // Images
    Route::get('images', 'AdminDashboardController@image')->name('pages.image');
    // Itineraire
    Route::get('itineraires', 'AdminDashboardController@itineraire')->name('pages.itineraire');
    // agence
    Route::get('likes', 'AdminDashboardController@like')->name('pages.like');
    // Location
    Route::get('locations', 'AdminDashboardController@location')->name('pages.location');
    //  Historique de Navigation
    Route::get('logs', 'AdminDashboardController@log')->name('pages.log');
    // Mode Facturation
    Route::get('modefacturations', 'AdminDashboardController@modefacturation')->name('pages.mode-facturation');
    // Note
    Route::get('notes', 'AdminDashboardController@note')->name('pages.note');
    // Pays
    Route::get('pay', 'AdminDashboardController@pays')->name('pages.pays');
    // Position Annonce
    Route::get('positions', 'AdminDashboardController@position')->name('pages.position');
    // Reservation
    Route::get('reservationlocations', 'AdminDashboardController@reservationlocation')->name('pages.reservation-location');
    //  Reservation Location
    Route::get('reservationvoyages', 'AdminDashboardController@reservationvoyage')->name('pages.reservation-voyage');
    // Site Touristique
    Route::get('sites', 'AdminDashboardController@site')->name('pages.site');
    // Tarif
    Route::get('tarifs', 'AdminDashboardController@tarif')->name('pages.tarif-annonce');
    // transaction
    Route::get('transactions', 'AdminDashboardController@transaction')->name('pages.transaction');
    // Ville
    Route::get('ville', 'AdminDashboardController@ville')->name('pages.ville');
    // Ville itineraire
    Route::get('ville-itineraires', 'AdminDashboardController@villeitineraire')->name('pages.ville-itineraire');
    // Voyage
    Route::get('voyages', 'AdminDashboardController@voyage')->name('pages.voyage');

    Route::get('transactions', 'AdminDashboardController@transaction')->name('pages.transaction');
    // Ville
    Route::get('villes', 'AdminDashboardController@ville')->name('pages.ville');
    // Ville itineraire
    Route::get('ville-itineraires', 'AdminDashboardController@villeitineraire')->name('pages.ville-itineraire');
    // Voyage
    Route::get('voyages', 'AdminDashboardController@voyage')->name('pages.voyage');

    Route::get('chambres', 'AdminDashboardController@chambre')->name('pages.chambre');
    Route::get('typechambres', 'AdminDashboardController@type_chambre')->name('pages.typechambre');
    Route::get('hotels', 'AdminDashboardController@hotel')->name('pages.hotel');



    Route::get('type-annonces', 'AdminDashboardController@typeannonce')->name('pages.typeannonce');

    Route::get('api', 'AdminDashboardController@api')->name('pages.api');




    //  Profile management

    Route::get('profile', 'AdminDashboardController@profile')->name('pages.mon-profile');
    Route::get('profile/edit', 'AdminDashboardController@profileEdit')->name('pages.mon-profile-edit');

   Route::get('/get-connected-user',function(){
        return response()->json(['user'=>Sentinel::getUser()]);
    })->name('connected.get-connected-user');
    Route::get('sentinel', function () {

        $user = Sentinel::getUser();
        $role = $user->role;
        $role_name = \App\Role::where('id', $role)->first();

        $is_admin = false;
        $is_client = false;
        $is_personnel = false;


        switch ($role) {
            case  1 :
                $is_admin = true;
                break;
            case  2 :
                $is_client = true;
            default :
                $is_personnel = true;

        }


        return response()->json([
            'data' => [
                'user' => $user,
                'role' => $role,
                'role_name' => $role_name->name
            ]
        ]);
    });

    /**
     *
     * Route for Vue js components
     * */

    Route::get('personnel/activate/{slug}', 'API\\PersonnelController@activation')->name('web-api.compte.activation-personnel');
    Route::get('personnel/desactivate/{slug}', 'API\\PersonnelController@deactivation')->name('web-api.compte.desactivation-personnel');
    Route::get('personnel/{slug}', 'API\\PersonnelController@show')->name('web-api.compte.detail-personnel');
    Route::post('create/personnel', 'API\\PersonnelController@store')->name('web-api.creation-personnel');
    Route::post('update-personnel', 'API\\InfoUpdatePersonnelController@update')->name('web-api.mise-ajours-personnel');
    Route::post('update-role/{slug}', 'API\\PersonnelController@changeRole')->name('web-api.mise-ajours-role');
    Route::delete('delete-personnel/{slug}', 'API\\PersonnelController@destroy')->name('web-api.suppression-personnel');
    Route::get('personnel', 'API\\PersonnelController@index')->name('web-api.liste-personnel');


  Route::get('agence', 'API\\AgenceController@index')->name('web-api.liste-agence');
  Route::get('agence/{slug}', 'API\\AgenceController@show')->name('web-api.detail-agence');
  Route::post('agence', 'API\\AgenceController@store')->name('web-api.creation-agence');
  Route::put('agence/{slug}', 'API\\AgenceController@update')->name('web-api.mise-a-jours-agence');
  Route::delete('agence/{slug}', 'API\\AgenceController@destroy')->name('web-api.suppression-agence');


  Route::get('article', 'API\\ArticleController@index')->name('web-api.liste-article');
  Route::get('article/{slug}', 'API\\ArticleController@show')->name('web-api.detail-article');
  Route::post('article', 'API\\ArticleController@store')->name('web-api.creation-article');
  Route::put('article/{slug}', 'API\\ArticleController@update')->name('web-api.mise-a-jours-article');
  Route::delete('article/{slug}', 'API\\ArticleController@destroy')->name('web-api.suppression-article');


  Route::get('annonce', 'API\\AnnonceController@index')->name('web-api.liste-annonce');
  Route::get('annonce/{slug}', 'API\\AnnonceController@show')->name('web-api.detail-annonce');
  Route::post('annonce', 'API\\AnnonceController@store')->name('web-api.creation-annonce');
  Route::put('annonce/{slug}', 'API\\AnnonceController@update')->name('web-api.mise-a-jours-annonce');
  Route::delete('annonce/{slug}', 'API\\AnnonceController@destroy')->name('web-api.suppression-annonce');


  Route::get('billet', 'API\\BilletController@index')->name('web-api.liste-billet');
  Route::get('billet/{slug}', 'API\\BilletController@show')->name('web-api.detail-billet');
  Route::post('billet', 'API\\BilletController@store')->name('web-api.creation-billet');
  Route::put('billet/{slug}', 'API\\BilletController@update')->name('web-api.mise-a-jours-billet');
  Route::delete('billet/{slug}', 'API\\BilletController@destroy')->name('web-api.suppression-billet');


  Route::get('categoriearticle', 'API\\CategorieArticleController@index')->name('web-api.liste-categoriearticle');
  Route::get('categoriearticle/{slug}', 'API\\CategorieArticleController@show')->name('web-api.detail-categoriearticle');
  Route::post('categoriearticle', 'API\\CategorieArticleController@store')->name('web-api.creation-categoriearticle');
  Route::put('categoriearticle/{slug}', 'API\\CategorieArticleController@update')->name('web-api.mise-a-jours-categoriearticle');
  Route::delete('categoriearticle/{slug}', 'API\\CategorieArticleController@destroy')->name('web-api.suppression-categoriearticle');

  Route::get('classe', 'API\ClasseController@index')->name('web-api.liste-classe');
  Route::get('classe/{slug}', 'API\ClasseController@show')->name('web-api.detail-classe');
  Route::post('classe', 'API\ClasseController@store')->name('web-api.creation-classe');
  Route::put('classe/{slug}', 'API\ClasseController@update')->name('web-api.mise-a-jours-classe');
  Route::delete('classe/{slug}', 'API\ClasseController@destroy')->name('web-api.suppression-classe');

  /*Route::get('commentaire/{slug}', 'API\\CommentaireController@show')->name('web-api.detail-commentaire');
  Route::post('commentaire', 'API\\CommentaireController@store')->name('web-api.creation-commentaire');
  Route::put('commentaire/{slug}', 'API\\CommentaireController@update')->name('web-api.mise-a-jours-commentaire');
  Route::delete('commentaire/{slug}', 'API\\CommentaireController@destroy')->name('web-api.suppression-commentaire');*/

  Route::get('image', 'API\\ImageController@index')->name('web-api.liste-image');
  Route::get('image/{slug}', 'API\\ImageController@show')->name('web-api.detail-image');
  Route::post('image', 'API\\ImageController@store')->name('web-api.creation-image');
  Route::put('image/{slug}', 'API\\ImageController@update')->name('web-api.mise-a-jours-image');
  Route::delete('image/{slug}', 'API\\ImageController@destroy')->name('web-api.suppression-image');

  Route::get('itineraire', 'API\\ItineraireController@index')->name('web-api.liste-itineraire');
  Route::get('itineraire/{slug}', 'API\\ItineraireController@show')->name('web-api.detail-itineraire');
  Route::post('itineraire', 'API\\ItineraireController@store')->name('web-api.creation-itineraire');
  Route::put('itineraire/{slug}', 'API\\ItineraireController@update')->name('web-api.mise-a-jours-itineraire');
  Route::delete('itineraire/{slug}', 'API\\ItineraireController@destroy')->name('web-api.suppression-itineraire');


  Route::get('location','API\\LocationController@index')->name('web-api.liste-location');
  Route::get('location/{slug}','API\\LocationController@show')->name('web-api.detail-location');
  Route::post('location','API\\LocationController@store')->name('web-api.creation-location');
  Route::put('location/{slug}','API\\LocationController@update')->name('web-api.mise-a-jours-location');
  Route::delete('location/{slug}','API\\LocationController@destroy')->name('web-api.suppression-location');
  Route::get('location/partenaire/{slug}', 'API\\LocationController@locationPartenaire')->name('web-api.location-partenaire');
  Route::post('location/deeper_search', 'API\\LocationController@deeper_search')->name('web-api.location_search');


  Route::get('modefacturation', 'API\\ModeFacturationController@index')->name('web-api.liste-modefacturation');
  Route::get('modefacturation/{slug}', 'API\\ModeFacturationController@show')->name('web-api.detail-modefacturation');
  Route::post('modefacturation', 'API\\ModeFacturationController@store')->name('web-api.creation-modefacturation');
  Route::put('modefacturation/{slug}', 'API\\ModeFacturationController@update')->name('web-api.mise-a-jours-modefacturation');
  Route::delete('modefacturation/{slug}', 'API\\ModeFacturationController@destroy')->name('web-api.suppression-modefacturation');

  Route::get('note', 'API\\NoteController@index')->name('web-api.liste-note');
  Route::get('note/{slug}', 'API\\NoteController@show')->name('web-api.detail-note');
  Route::post('note', 'API\\NoteController@store')->name('web-api.creation-note');
  Route::put('note/{slug}', 'API\\NoteController@update')->name('web-api.mise-a-jours-note');
  Route::delete('note/{slug}', 'API\\NoteController@destroy')->name('web-api.suppression-note');

  Route::get('notification', 'API\\NotificationController@index')->name('web-api.liste-notification');
  Route::get('notification/{slug}', 'API\\NotificationController@show')->name('web-api.detail-notification');
  Route::post('notification', 'API\\NotificationController@store')->name('web-api.creation-notification');
  Route::put('notification/{slug}', 'API\\NotificationController@update')->name('web-api.mise-a-jours-notification');
  Route::delete('notification/{slug}', 'API\\NotificationController@destroy')->name('web-api.suppression-notification');

  Route::get('pays', 'API\\PaysController@index')->name('web-api.liste-pays');
  Route::get('pays/{slug}', 'API\\PaysController@show')->name('web-api.detail-pays');
  Route::get('pays/{slug}/villes', 'API\\PaysController@villes')->name('web-api.liste-pays-ville');
  Route::get('pays/{slug}/decoupage', 'API\\PaysController@decoupage')->name('web-api.liste-pays-decoupage');
  Route::post('pays', 'API\\PaysController@store')->name('web-api.creation-pays');
  Route::put('pays/{slug}', 'API\\PaysController@update')->name('web-api.mise-a-jours-pays');
  Route::delete('pays/{slug}', 'API\\PaysController@destroy')->name('web-api.suppression-pays');

  Route::get('positionannonce', 'API\\PositionAnnonceController@index')->name('web-api.liste-positionannonce');
  Route::get('positionannonce/{slug}', 'API\\PositionAnnonceController@show')->name('web-api.detail-positionannonce');
  Route::post('positionannonce', 'API\\PositionAnnonceController@store')->name('web-api.creation-positionannonce');
  Route::put('positionannonce/{slug}', 'API\\PositionAnnonceController@update')->name('web-api.mise-a-jours-positionannonce');
  Route::delete('positionannonce/{slug}', 'API\\PositionAnnonceController@destroy')->name('web-api.suppression-positionannonce');


  Route::get('reservationvoyage', 'API\\ReservationVoyageController@index')->name('web-api.liste-reservationvoyage');
  Route::get('reservationvoyage/{slug}', 'API\\ReservationVoyageController@show')->name('web-api.detail-reservationvoyage');
  Route::post('reservationvoyage', 'API\\ReservationVoyageController@store')->name('web-api.creation-reservationvoyage');
  Route::put('reservationvoyage/{slug}', 'API\\ReservationVoyageController@update')->name('web-api.mise-a-jours-reservationvoyage');
  Route::delete('reservationvoyage/{slug}', 'API\\ReservationVoyageController@destroy')->name('web-api.suppression-billet');

  Route::get('reservationlocation', 'API\\ReservationLocationController@index')->name('web-api.liste-reservationlocation');
  Route::get('reservationlocation/{slug}', 'API\\ReservationLocationController@show')->name('web-api.detail-reservationlocation');
  Route::post('reservationlocation', 'API\\ReservationLocationController@store')->name('web-api.creation-reservationlocation');
  Route::put('reservationlocation/{slug}', 'API\\ReservationLocationController@update')->name('web-api.mise-a-jours-reservationlocation');
  Route::delete('reservationlocation/{slug}', 'API\\ReservationLocationController@destroy')->name('web-api.suppression-reservationlocation');

  Route::get('province', 'API\\ProvinceController@index')->name('web-api.liste-province');
  Route::get('province/{slug}', 'API\\ProvinceController@show')->name('web-api.detail-province');
  Route::post('province', 'API\\ProvinceController@store')->name('web-api.creation-province');
  Route::put('province/{slug}', 'API\\ProvinceController@update')->name('web-api.mise-a-jours-province');
  Route::delete('province/{slug}', 'API\\ProvinceController@destroy')->name('web-api.suppression-province');


  Route::get('decoupageun', 'API\\DecoupageUnController@index')->name('web-api.liste-decoupageun');
  Route::get('decoupageun/{slug}', 'API\\DecoupageUnController@show')->name('web-api.detail-decoupageun');
  Route::post('decoupageun', 'API\\DecoupageUnController@store')->name('web-api.creation-decoupageun');
  Route::put('decoupageun/{slug}', 'API\\DecoupageUnController@update')->name('web-api.mise-a-jours-decoupageun');
  Route::delete('decoupageun/{slug}', 'API\\DecoupageUnController@destroy')->name('web-api.suppression-decoupageun');

  Route::get('decoupagedeux', 'API\\DecoupageDeuxController@index')->name('web-api.liste-decoupagedeux');
  Route::get('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@show')->name('web-api.detail-decoupagedeux');
  Route::post('decoupagedeux', 'API\\DecoupageDeuxController@store')->name('web-api.creation-decoupagedeux');
  Route::put('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@update')->name('web-api.mise-a-jours-decoupagedeux');
  Route::delete('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@destroy')->name('web-api.suppression-decoupagedeux');

  Route::get('decoupagetrois', 'API\\DecoupageTroisController@index')->name('web-api.liste-decoupagetrois');
  Route::get('decoupagetrois/{slug}', 'API\\DecoupageTroisController@show')->name('web-api.detail-decoupagetrois');
  Route::post('decoupagetrois', 'API\\DecoupageTroisController@store')->name('web-api.creation-decoupagetrois');
  Route::put('decoupagetrois/{slug}', 'API\\DecoupageTroisController@update')->name('web-api.mise-a-jours-decoupagetrois');
  Route::delete('decoupagetrois/{slug}', 'API\\DecoupageTroisController@destroy')->name('web-api.suppression-decoupagetrois');

  Route::get('site', 'API\\SiteController@index')->name('web-api.liste-site');
  Route::get('site/{slug}', 'API\\SiteController@show')->name('web-api.detail-site');
  Route::post('site', 'API\\SiteController@store')->name('web-api.creation-site');
  Route::put('site/{slug}', 'API\\SiteController@update')->name('web-api.mise-a-jours-site');
  Route::delete('site/{slug}', 'API\\SiteController@destroy')->name('web-api.suppression-site');

  Route::get('tarifannonce', 'API\\TarifAnnonceController@index')->name('web-api.liste-tarifannonce');
  Route::get('tarifannonce/{slug}', 'API\\TarifAnnonceController@show')->name('web-api.detail-tarifannonce');
  Route::post('tarifannonce', 'API\\TarifAnnonceController@store')->name('web-api.creation-tarifannonce');
  Route::put('tarifannonce/{slug}', 'API\\TarifAnnonceController@update')->name('web-api.mise-a-jours-tarifannonce');
  Route::delete('tarifannonce/{slug}', 'API\\TarifAnnonceController@destroy')->name('web-api.suppression-tarifannonce');

  Route::get('transaction', 'API\\TransactionController@index')->name('web-api.liste-transaction');
  Route::get('transaction/{slug}', 'API\\TransactionController@show')->name('web-api.detail-transaction');
  Route::post('transaction', 'API\\TransactionController@store')->name('web-api.creation-transaction');
  Route::put('transaction/{slug}', 'API\\TransactionController@update')->name('web-api.mise-a-jours-transaction');
  Route::delete('transaction/{slug}', 'API\\TransactionController@destroy')->name('web-api.suppression-billet');

  Route::get('typeannonce', 'API\\TypeAnnonceController@index')->name('web-api.liste-typeannonce');
  Route::get('typeannonce/{slug}', 'API\\TypeAnnonceController@show')->name('web-api.detail-typeannonce');
  Route::post('typeannonce', 'API\\TypeAnnonceController@store')->name('web-api.creation-typeannonce');
  Route::put('typeannonce/{slug}', 'API\\TypeAnnonceController@update')->name('web-api.mise-a-jours-typeannonce');
  Route::delete('typeannonce/{slug}', 'API\\TypeAnnonceController@destroy')->name('web-api.suppression-typeannonce');

  /*---Begin--*/

  Route::get('chambre', 'API\\ChambreController@index')->name('web-api.liste-chambre');
  Route::get('chambre/{slug}', 'API\\ChambreController@show')->name('web-api.detail-chambre');
  Route::post('chambre', 'API\\ChambreController@store')->name('web-api.creation-chambre');
  Route::put('chambre/{slug}', 'API\\ChambreController@update')->name('web-api.mise-a-jours-chambre');
  Route::delete('chambre/{slug}', 'API\\ChambreController@destroy')->name('web-api.suppression-chambre');


  Route::get('type-chambre', 'API\\TypeChambreController@index')->name('web-api.liste-type-chambre');
  Route::get('type-chambre/{slug}', 'API\\TypeChambreController@show')->name('web-api.detail-type-chambre');
  Route::post('type-chambre', 'API\\TypeChambreController@store')->name('web-api.creation-type-chambre');
  Route::put('type-chambre/{slug}', 'API\\TypeChambreController@update')->name('web-api.mise-a-jours-type-chambre');
  Route::delete('type-chambre/{slug}', 'API\\TypeChambreController@destroy')->name('web-api.suppression-type-chambre');


  Route::get('hotel', 'API\\HotelController@index')->name('web-api.liste-hotel');
  Route::get('hotel/{slug}', 'API\\HotelController@show')->name('web-api.detail-hotel');
  Route::post('hotel', 'API\\HotelController@store')->name('web-api.creation-hotel');
  Route::put('hotel/{slug}', 'API\\HotelController@update')->name('web-api.mise-a-jours-hotel');
  Route::delete('hotel/{slug}', 'API\\HotelController@destroy')->name('web-api.suppression-hotel');

  /*---End--*/


  Route::get('ville', 'API\\VilleController@index')->name('web-api.liste-ville');
  Route::get('ville/{slug}', 'API\\VilleController@show')->name('web-api.detail-ville');
  Route::post('ville', 'API\\VilleController@store')->name('web-api.creation-ville');
  Route::put('ville/{slug}', 'API\\VilleController@update')->name('web-api.mise-a-jours-ville');
  Route::delete('ville/{slug}', 'API\\VilleController@destroy')->name('web-api.suppression-ville');

  Route::get('villeitineraire', 'API\\VilleItineraireController@index')->name('web-api.liste-villeitineraire');
  Route::get('villeitineraire/{slug}', 'API\\VilleItineraireController@show')->name('web-api.detail-villeitineraire');
  Route::post('villeitineraire', 'API\\VilleItineraireController@store')->name('web-api.creation-villeitineraire');
  Route::put('villeitineraire/{slug}', 'API\\VilleItineraireController@update')->name('web-api.mise-a-jours-villeitineraire');
  Route::delete('villeitineraire/{slug}', 'API\\VilleItineraireController@destroy')->name('web-api.suppression-villeitineraire');



  Route::get('client/activate/{slug}', 'API\\ClientController@activation')->name('web-api.compte.activation-client');
  Route::get('client/desactivate/{slug}', 'API\\ClientController@deactivation')->name('web-api.compte.desactivation-client');
  Route::get('client', 'API\\ClientController@index')->name('web-api.liste-client');
  Route::get('client/{slug}', 'API\\ClientController@show')->name('web-api.compte.detail-personnel');
  Route::post('create/client', 'API\\ClientController@store')->name('web-api.creation-client');
  Route::post('update-client', 'API\\InfoUpdateClientController@update')->name('web-api.mise-a-jours-client');
  Route::delete('delete-client/{slug}', 'API\\ClientController@destroy')->name('web-api.suppression-client');


  Route::get('admin/activate/{slug}', 'API\\AdminController@activation')->name('web-api.compte.activation-admin');
  Route::get('admin/desactivate/{slug}', 'API\\AdminController@deactivation')->name('web-api.compte.desactivation-admin');
  Route::get('admin', 'API\\AdminController@index')->name('web-api.liste-admin');
  Route::post('create/admin', 'API\\AdminController@store')->name('web-api.creation-admin');
  Route::post('update-admin', 'API\\InfoUpdateAdminController@update')->name('web-api.mise-a-jours-admin');
  Route::delete('delete-admin/{slug}', 'API\\AdminController@destroy')->name('web-api.suppression-admin');



  // roles

  Route::get('role-personnel', 'API\\RoleController@personnel')->name('web-api.role-personnel');


  Route::post('reset-password', 'API\\PasswordResetController@reset')->name('web-api.mise-a-jours-mot-de-pass');


  Route::apiResource('log', 'API\\LogController');


Route::get('location','API\\LocationController@index')->name('web-api.liste-location');
Route::get('location/{slug}','API\\LocationController@show')->name('web-api.detail-location');
Route::post('location','API\\LocationController@store')->name('web-api.creation-location');
Route::put('location/{slug}','API\\LocationController@update')->name('web-api.mise-a-jours-location');
Route::delete('location/{slug}','API\\LocationController@destroy')->name('web-api.suppression-location');
Route::get('location/partenaire/{slug}', 'API\\LocationController@locationPartenaire')->name('web-api.location-partenaire');
Route::post('location/deeper_search', 'API\\LocationController@deeper_search')->name('web-api.location_search');

Route::get('voyage','API\\VoyageController@index')->name('web-api.liste-voyage');
Route::get('voyage/{slug}','API\\VoyageController@show')->name('web-api.detail-voyage');
Route::post('voyage','API\\VoyageController@store')->name('web-api.creation-voyage');
Route::put('voyage/{slug}','API\\VoyageController@update')->name('web-api.mise-a-jours-voyage');
Route::delete('voyage/{slug}','API\\VoyageController@destroy')->name('web-api.suppression-voyage');
Route::get('voyage/partenaire/{slug}', 'API\\VoyageController@voyagePartenaire')->name('web-api.voyage-partenaire');
Route::post('voyage/deeper_search', 'API\\VoyageController@deeper_search')->name('web-api.voyage_search');


Route::get('partenaire','API\\PartenaireController@index')->name('web-api.liste-partenaire');
Route::get('partenaire/{slug}','API\\PartenaireController@show')->name('web-api.detail-partenaire');
Route::post('partenaire','API\\PartenaireController@store')->name('web-api.creation-partenaire');
Route::put('partenaire/{slug}','API\\PartenaireController@update')->name('web-api.mise-a-jours-partenaire');
Route::delete('partenaire/{slug}','API\\PartenaireController@destroy')->name('web-api.suppression-partenaire');
Route::get('partenaire/activate/{slug}', 'API\\PartenaireController@activation')->name('compte.activation-partenaire');
Route::get('partenaire/desactivate/{slug}', 'API\\PartenaireController@deactivation')->name('compte.desactivation-partenaire');
Route::get('partenaire/bloquer/{slug}', 'API\\PartenaireController@bloquer')->name('web-api.bloque-partenaire');
Route::get('partenaire/debloquer/{slug}', 'API\\PartenaireController@debloquer')->name('web-api.debloque-partenaire');
Route::get('partenaire/deeper_search_villes/{key}', 'API\\PartenaireController@deeper_search_villes')->name('web-api.search-partenaire');
Route::get('partenaire/deeper_search_pays/{key}', 'API\\PartenaireController@deeper_search_pays')->name('web-api.search-pays-partenaire');

// Charger les villes d'un pays
Route::get('ville-pays/{pays}', 'API\\VilleController@pays_ville');

// retourner une ville à partir de son ID
Route::get('ville_id/{id}', 'API\\VilleController@ville_id');

// Modifier l'état d'un voyage
Route::put('change_state_voyage/{slug}', 'API\\VoyageController@change_state');

// Modifier l'état d'une location
route::put('change_state_location/{slug}', 'API\\LocationController@change_state');

// Charger les stats
    Route::get('nombre-voyages', 'API\\DashboardStatsController@voyages');
    Route::get('nombre-reservations-confirmes', 'API\\DashboardStatsController@reservationsConfirmes');
    Route::get('nombre-reservations-annules', 'API\\DashboardStatsController@reservationsAnnules');
    Route::get('nombre-clients', 'API\\DashboardStatsController@clients');
    Route::get('nombre-locations', 'API\\DashboardStatsController@locations');
    Route::get('total-recette-voyage', 'API\\DashboardStatsController@recettesVoyages');
    Route::get('voyageByMois/{mois}', 'API\\DashboardStatsController@reservationsByAnnee');
    Route::get('locationByMois/{mois}', 'API\\DashboardStatsController@locationsByAnnee');
    Route::get('voyages-client-jour', 'API\\DashboardStatsController@voyagesClientParJour');


    //Route partie vidila

    // Voyage
    Route::get('voyages-partenaire', 'AdminDashboardController@voyagePartenaire')->name('pages.voyage-partenaire');
    Route::get('locations-partenaire', 'AdminDashboardController@locationPartenaire')->name('pages.location-partenaire');


Route::get('location-partenaire','API\\LocationPartenaireController@index')->name('web-api.liste-location-partenaire');
Route::get('location-partenaire/{slug}','API\\LocationPartenaireController@show')->name('web-api.detail-location-partenaire');
Route::post('location-partenaire','API\\LocationPartenaireController@store')->name('web-api.creation-location-partenaire');
Route::put('location-partenaire/{slug}','API\\LocationPartenaireController@update')->name('web-api.mise-a-jours-location-partenaire');
Route::delete('location-partenaire/{slug}','API\\LocationPartenaireController@destroy')->name('web-api.suppression-location-partenaire');
Route::post('location-partenaire/deeper_search', 'API\\LocationPartenaireController@deeper_search')->name('web-api.location_search-partenaire');


Route::get('voyage','API\\VoyageController@index')->name('web-api.liste-voyage');
Route::get('voyage/{slug}','API\\VoyageController@show')->name('web-api.detail-voyage');
Route::post('voyage','API\\VoyageController@store')->name('web-api.creation-voyage');
Route::put('voyage/{slug}','API\\VoyageController@update')->name('web-api.mise-a-jours-voyage');
Route::delete('voyage/{slug}','API\\VoyageController@destroy')->name('web-api.suppression-voyage');
Route::get('voyage/partenaire/{slug}', 'API\\VoyageController@voyagePartenaire')->name('web-api.voyage-partenaire');
Route::post('voyage/deeper_search', 'API\\VoyageController@deeper_search')->name('web-api.voyage_search');



Route::get('voyage-partenaire','API\\VoyagePartenaireController@index')->name('web-api.liste-voyage-partenaire');
Route::get('voyage-partenaire/{slug}','API\\VoyagePartenaireController@show')->name('web-api.detail-voyage-partenaire');
Route::post('voyage-partenaire','API\\VoyagePartenaireController@store')->name('web-api.creation-voyage-partenaire');
Route::put('voyage-partenaire/{slug}','API\\VoyagePartenaireController@update')->name('web-api.mise-a-jours-voyage-partenaire');
Route::delete('voyage-partenaire/{slug}','API\\VoyagePartenaireController@destroy')->name('web-api.suppression-voyage-partenaire');
Route::get('voyage-partenaire/partenaire/{slug}', 'API\\VoyagePartenaireController@voyagePartenaire')->name('web-api.voyage-partenaire-partenaire');
Route::post('voyage-partenaire/deeper_search', 'API\\VoyagePartenaireController@deeper_search')->name('web-api.voyage_search');




});
