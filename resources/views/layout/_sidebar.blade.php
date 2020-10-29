<div class="sidebar" data-background-color="withe" data-active-color="danger">
<div class="logo sweety">
        <a href="#" class="simple-text logo-mini">
            GV
        </a>

        <a href="#" class="simple-text logo-normal">
            GVOYAGE
        </a>
    </div>
    <div class="sidebar-wrapper sweety">
    <?php $user=Sentinel::getUser();  ?>

        <div class="user">
            <div class="photo">
                <img src="{{url('images/default.png')}}"/>
            </div>
            <div class="info">
                 <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        <span>Bienvenue,</span>
                            <span>{{$user->first_name.' ' .$user->last_name }}</span  >
                </a>
                <div class="clearfix"></div>

                <div class="collapse" id="collapseExample">
                    <ul class="nav text-center">
                        <li>
                            <a href="{{route('pages.mon-profile')}}">
                                <span class="sidebar-normal">Mon Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#edit">
                                <span class="sidebar-normal">Editer Profile</span>
                            </a>
                        </li>
                        <li>
                        {!! Form::open(['url' => url('logout'),'class'=>'form-inline']) !!}
                        {!! csrf_field() !!}
                        <li><span class="sidebar-normal"><button class="btn btn-danger btn-xs text-center"
                                                                 type="submit">Se Deconnecter</button></span></li>
                        {!! Form::close() !!}
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav sweety">
        <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <p>Tableau de bord</p>
                </a>
            </li>
            @if ($user->hasAnyAccess(['user.*']))


            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="fa fa-spinner text-right"></i>
                    <p>
                    @if($user->inRole('admin') || $user->inRole('super-admin')) 
                        Partenaire & 
                         @endif
                        Offres 
                                         <b class="caret"></b>
                    </p>
                </a>
                @if($user->inRole('admin') || $user->inRole('super-admin'))


                <div class="collapse " id="pagesExamples">
                    <ul class="nav">

                        <li class="text-center">
                            <a href="{{ route('pages.partenaire')}}">
                                <span class="sidebar-normal"> Partenaires </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="{{ route('pages.voyage')}}">
                                <span class="sidebar-normal"> Voyage </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="{{route('pages.location')}}">
                                <span class="sidebar-normal"> Location </span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                @if($user->inRole('partenaire') || $user->inRole('controlleur') || $user->inRole('technicien'))
                <div class="collapse " id="pagesExamples">
                    <ul class="nav">

                      

                        <li class="text-center">
                            <a href="{{ route('pages.voyage')}}">
                                <span class="sidebar-normal"> Voyage </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="{{route('pages.location')}}">
                                <span class="sidebar-normal"> Location </span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

            </li>

            @endif



            @if($user->inRole('admin') || $user->inRole('super-admin'))
           @if ($user->hasAnyAccess(['user.*']))
              <li>
                  <a data-toggle="collapse" href="#annonce">
                      <i class="fa fa-exclamation-triangle text-right"></i>
                      <p>
                          Annonces
                          <b class="caret"></b>
                      </p>
                  </a>
                  <div class="collapse " id="annonce">
                      <ul class="nav">
                          <li class="text-center">
                              <a href="{{route('pages.annonce')}}">
                                  <span class="sidebar-normal"> Annonces </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="{{route('pages.typeannonce')}}">
                                  <span class="sidebar-normal"> Type annonce </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="{{route('pages.position')}}">
                                  <span class="sidebar-normal"> Position </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="{{route('pages.tarif-annonce')}}">
                                  <span class="sidebar-normal"> Tarif </span>
                              </a>
                          </li>


                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a href="{{route('pages.publicite')}}">
                      <i  class="fa fa-bullhorn text-right"></i>
                      <p><span>Publicité</span></p></a>
              </li>

            @endif

            @if ($user->hasAnyAccess(['user.*']))

            <li>
                <a data-toggle="collapse" href="#articles">
                    <i class="fa fa-list text-right"></i>
                    <p>
                        Articles
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="articles">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="{{ route('pages.article') }}">
                                <span class="sidebar-normal"> Cr&eacute;ation article </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{ route('pages.categorie') }}">
                                <span class="sidebar-normal"> Catégorie Article </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif    
            @if ($user->hasAnyAccess(['user.*']))


         

                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="{{route('pages.site')}}"><i
                                class="fa fa-map text-right"></i>
                        <p><span>Sites Touristiques</span></p></a>

                </li>

            @endif
            @endif
                   

        

            @if ($user->hasAnyAccess(['user.*']))
            <li><a  data-toggle="collapse" href="#user"><i class="fa fa-users"></i>Utilisateurs <span class="fa fa-chevron-down"></span></a>
                <div class="collapse " id="user">

                    <ul class="nav child_menu">
                        @if($user->inRole('admin') || $user->inRole('super-admin'))
                            <li><a href="{{route('user.index')}}">Les utilisateurs</a></li>
                            <li >
                            <a href="{{ route('pages.client') }}">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                            </li>
                            <li >
                            <a href="{{ route('pages.personnel') }}">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                            </li>
                        @endif
                        @if($user->inRole('partenaire'))
                            <li >
                            <a href="{{ route('pages.client') }}">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                            </li>
                            <li >
                            <a href="{{ route('pages.personnel') }}">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
          @endif
          
          @if ($user->hasAnyAccess(['role.*']))
                <li><a data-toggle="collapse" href="#param"><i class="fa fa-cog "></i> Paramétre<span class="fa fa-chevron-down"></span></a>
                    <div class="collapse " id="param">

                        <ul class="nav child_menu">

                                <li><a href="#level1_1">Mon compte</a></li>


                                @if($user->inRole('partenaire'))

                                        <li><a href="#level1_1">Accès</a></li>

                                @endif

                                @if($user->inRole('admin') || $user->inRole('super-admin'))

                                    <li><a href="#level1_1">Accès</a></li>
                            
                                    <li><a data-toggle="collapse" href="#role"><i class="fa fa fa-sitemap "></i>Roles <span class="fa fa-chevron-down"></span></a>
                                        <div class="collapse " id="role">

                                            <ul class="nav child_menu">
                                                <li><a href="{{route('pages.getroles')}}">Les roles</a></li>
                                                <li><a href="{{route('role.create')}}">Créer role</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li><a data-toggle="collapse" href="#localite"><i class="fa fa-building-o "></i>Localités <span class="fa fa-chevron-down"></span></a>
                                        <div class="collapse " id="localite">
                    
                                            <ul class="nav child_menu">
                                                    <li><a href="{{route('pages.decoupage-un')}}">Provinces</a></li>
                                                    <li >
                                                        <a href="{{ route('pages.ville') }}">
                                                            <span class="sidebar-normal"> Villes </span>
                                                        </a>
                                                    </li>
                                                    <li >
                                                        <a href="{{route('pages.pays')}}">
                                                            <span class="sidebar-normal"> Pays </span>
                                                        </a>
                                                    </li>
                                                    @if ($user->hasAnyAccess(['role.*']))
                                                        <li >
                                                            <a href="{{ route('pages.getroles') }}">
                                                                <span class="sidebar-normal"> Role & Permissions </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if ($user->hasAnyAccess(['role.*']))

                                                        <li >
                                                            <a class="nav-link btn-magnify" href="{{route('pages.api')}}">
                                                                <span>API</span>
                                                            </a>
                                                        </li>

                                                    @endif
                                                    <!-- <li><a href="{{route('user.create')}}">Nouveau Utilisateurs</a></li> -->
                                            </ul>

                                        </div>
                                    </li>

                                @endif

                            
                        </ul>
                    </div>
                </li> 
            @endif

            @if ($user->hasAnyAccess(['role.*']))
                <li><a href="{{route('pages.log')}}"><i class="fa fa-globe"></i> Historiques <span class=""></span></a></li>
            @endif 
        </ul>

    </div>
</div>
