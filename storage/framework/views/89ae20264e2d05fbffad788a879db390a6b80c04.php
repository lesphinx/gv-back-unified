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
                <img src="<?php echo e(url('images/default.png')); ?>"/>
            </div>
            <div class="info">
                 <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        <span>Bienvenue,</span>
                            <span><?php echo e($user->first_name.' ' .$user->last_name); ?></span  >
                </a>
                <div class="clearfix"></div>

                <div class="collapse" id="collapseExample">
                    <ul class="nav text-center">
                        <li>
                            <a href="<?php echo e(route('pages.mon-profile')); ?>">
                                <span class="sidebar-normal">Mon Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#edit">
                                <span class="sidebar-normal">Editer Profile</span>
                            </a>
                        </li>
                        <li>
                        <?php echo Form::open(['url' => url('logout'),'class'=>'form-inline']); ?>

                        <?php echo csrf_field(); ?>

                        <li><span class="sidebar-normal"><button class="btn btn-danger btn-xs text-center"
                                                                 type="submit">Se Deconnecter</button></span></li>
                        <?php echo Form::close(); ?>

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
            <?php if($user->hasAnyAccess(['user.*'])): ?>


            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="fa fa-spinner text-right"></i>
                    <p>
                    <?php if($user->inRole('admin') || $user->inRole('super-admin')): ?> 
                        Partenaire & 
                         <?php endif; ?>
                        Offres 
                                         <b class="caret"></b>
                    </p>
                </a>
                <?php if($user->inRole('admin') || $user->inRole('super-admin')): ?>


                <div class="collapse " id="pagesExamples">
                    <ul class="nav">

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.partenaire')); ?>">
                                <span class="sidebar-normal"> Partenaires </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.voyage')); ?>">
                                <span class="sidebar-normal"> Voyage </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.location')); ?>">
                                <span class="sidebar-normal"> Location </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if($user->inRole('partenaire') || $user->inRole('controlleur') || $user->inRole('technicien')): ?>
                <div class="collapse " id="pagesExamples">
                    <ul class="nav">

                      

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.voyage')); ?>">
                                <span class="sidebar-normal"> Voyage </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.location')); ?>">
                                <span class="sidebar-normal"> Location </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

            </li>

            <?php endif; ?>



            <?php if($user->inRole('admin') || $user->inRole('super-admin')): ?>
           <?php if($user->hasAnyAccess(['user.*'])): ?>
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
                              <a href="<?php echo e(route('pages.annonce')); ?>">
                                  <span class="sidebar-normal"> Annonces </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="<?php echo e(route('pages.typeannonce')); ?>">
                                  <span class="sidebar-normal"> Type annonce </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="<?php echo e(route('pages.position')); ?>">
                                  <span class="sidebar-normal"> Position </span>
                              </a>
                          </li>
                          <li class="text-center">
                              <a href="<?php echo e(route('pages.tarif-annonce')); ?>">
                                  <span class="sidebar-normal"> Tarif </span>
                              </a>
                          </li>


                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a href="<?php echo e(route('pages.publicite')); ?>">
                      <i  class="fa fa-bullhorn text-right"></i>
                      <p><span>Publicité</span></p></a>
              </li>

            <?php endif; ?>

            <?php if($user->hasAnyAccess(['user.*'])): ?>

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
                            <a href="<?php echo e(route('pages.article')); ?>">
                                <span class="sidebar-normal"> Cr&eacute;ation article </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.categorie')); ?>">
                                <span class="sidebar-normal"> Catégorie Article </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>    
            <?php if($user->hasAnyAccess(['user.*'])): ?>


         

                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="<?php echo e(route('pages.site')); ?>"><i
                                class="fa fa-map text-right"></i>
                        <p><span>Sites Touristiques</span></p></a>

                </li>

            <?php endif; ?>
            <?php endif; ?>
                   

        

            <?php if($user->hasAnyAccess(['user.*'])): ?>
            <li><a  data-toggle="collapse" href="#user"><i class="fa fa-users"></i>Utilisateurs <span class="fa fa-chevron-down"></span></a>
                <div class="collapse " id="user">

                    <ul class="nav child_menu">
                        <?php if($user->inRole('admin') || $user->inRole('super-admin')): ?>
                            <li><a href="<?php echo e(route('user.index')); ?>">Les utilisateurs</a></li>
                            <li >
                            <a href="<?php echo e(route('pages.client')); ?>">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                            </li>
                            <li >
                            <a href="<?php echo e(route('pages.personnel')); ?>">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                            </li>
                        <?php endif; ?>
                        <?php if($user->inRole('partenaire')): ?>
                            <li >
                            <a href="<?php echo e(route('pages.client')); ?>">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                            </li>
                            <li >
                            <a href="<?php echo e(route('pages.personnel')); ?>">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
          <?php endif; ?>
          
          <?php if($user->hasAnyAccess(['role.*'])): ?>
                <li><a data-toggle="collapse" href="#param"><i class="fa fa-cog "></i> Paramétre<span class="fa fa-chevron-down"></span></a>
                    <div class="collapse " id="param">

                        <ul class="nav child_menu">

                                <li><a href="#level1_1">Mon compte</a></li>


                                <?php if($user->inRole('partenaire')): ?>

                                        <li><a href="#level1_1">Accès</a></li>

                                <?php endif; ?>

                                <?php if($user->inRole('admin') || $user->inRole('super-admin')): ?>

                                    <li><a href="#level1_1">Accès</a></li>
                            
                                    <li><a data-toggle="collapse" href="#role"><i class="fa fa fa-sitemap "></i>Roles <span class="fa fa-chevron-down"></span></a>
                                        <div class="collapse " id="role">

                                            <ul class="nav child_menu">
                                                <li><a href="<?php echo e(route('pages.getroles')); ?>">Les roles</a></li>
                                                <li><a href="<?php echo e(route('role.create')); ?>">Créer role</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li><a data-toggle="collapse" href="#localite"><i class="fa fa-building-o "></i>Localités <span class="fa fa-chevron-down"></span></a>
                                        <div class="collapse " id="localite">
                    
                                            <ul class="nav child_menu">
                                                    <li><a href="<?php echo e(route('pages.decoupage-un')); ?>">Provinces</a></li>
                                                    <li >
                                                        <a href="<?php echo e(route('pages.ville')); ?>">
                                                            <span class="sidebar-normal"> Villes </span>
                                                        </a>
                                                    </li>
                                                    <li >
                                                        <a href="<?php echo e(route('pages.pays')); ?>">
                                                            <span class="sidebar-normal"> Pays </span>
                                                        </a>
                                                    </li>
                                                    <?php if($user->hasAnyAccess(['role.*'])): ?>
                                                        <li >
                                                            <a href="<?php echo e(route('pages.getroles')); ?>">
                                                                <span class="sidebar-normal"> Role & Permissions </span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($user->hasAnyAccess(['role.*'])): ?>

                                                        <li >
                                                            <a class="nav-link btn-magnify" href="<?php echo e(route('pages.api')); ?>">
                                                                <span>API</span>
                                                            </a>
                                                        </li>

                                                    <?php endif; ?>
                                                    <!-- <li><a href="<?php echo e(route('user.create')); ?>">Nouveau Utilisateurs</a></li> -->
                                            </ul>

                                        </div>
                                    </li>

                                <?php endif; ?>

                            
                        </ul>
                    </div>
                </li> 
            <?php endif; ?>

            <?php if($user->hasAnyAccess(['role.*'])): ?>
                <li><a href="<?php echo e(route('pages.log')); ?>"><i class="fa fa-globe"></i> Historiques <span class=""></span></a></li>
            <?php endif; ?> 
        </ul>

    </div>
</div>
