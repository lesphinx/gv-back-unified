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
        <div class="user">
            <div class="photo">
                <img src="<?php echo e(url('images/default.png')); ?>"/>
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        <span>
								Jon Snow
		                        <b class="caret"></b>
							</span>
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

            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="fa fa-spinner text-right"></i>
                    <p>
                        Partenaire & Offres
                        <b class="caret"></b>
                    </p>
                </a>
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
            </li>




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
                                <span class="sidebar-normal"> Articles </span>
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
            <!--
                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="<?php echo e(route('pages.image')); ?>"><i
                                class="fa fa-camera text-right"></i>
                        <p><span>Gallerie</span></p></a>
                </li>


                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="<?php echo e(route('pages.site')); ?>"><i
                                class="fa fa-map text-right"></i>
                        <p><span>Sites Touristiques</span></p></a>

                </li>
            <li>
                <a data-toggle="collapse" href="#comments">
                    <i class="fa fa-commenting-o text-right"></i>
                    <p>
                        Commentaires
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="comments">
                    <ul class="nav">

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.commentaire')); ?>">
                                <span class="sidebar-normal">Commentaires </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.note')); ?>">
                                <span class="sidebar-normal">Notes </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="<?php echo e(route('pages.like')); ?>">
                                <span class="sidebar-normal">Likes </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

        -->
            <li>
                <a data-toggle="collapse" href="#city">
                    <i class="fa fa-building-o text-right"></i>
                    <p>
                        Localités
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="city">
                    <ul class="nav">

                        
                            <!--
                                <li class="text-center">
                            <a data-toggle="collapse" href="#decoupage">
                                <span class="sidebar-normal"> Decoupages </span>
                            </a>
                            <div class="collapse" id="decoupage">
                                <ul class="nav">
                                    <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>

                                        <li class="text-center">
                                            <a href="<?php echo e(route('pages.decoupage-un')); ?>">
                                                <span class="sidebar-normal"> --Découpage un--</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>
                                        <li class="text-center">
                                            <a href="<?php echo e(route('pages.decoupage-deux')); ?>">
                                                <span class="sidebar-normal"> --Découpage deux-- </span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>

                                        <li class="text-center">
                                            <a href="<?php echo e(route('pages.decoupage-trois')); ?>">
                                                <span class="sidebar-normal"> --Découpage Trois--</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    -->
                        <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>
                            <li class="text-center">
                                <a href="<?php echo e(route('pages.ville')); ?>">
                                    <span class="sidebar-normal"> Villes </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>
                            <li class="text-center">
                                <a href="<?php echo e(route('pages.pays')); ?>">
                                    <span class="sidebar-normal"> Pays </span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
                            <!--

            <li>
                <a data-toggle="collapse" href="#chambre">
                    <i class="nc-icon nc-bank text-right"></i>
                    <p>
                        Chambres & Hotels
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="chambre">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.hotel')); ?>">
                                <span class="sidebar-normal"> Hotels </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.chambre')); ?>">
                                <span class="sidebar-normal"> Chambres </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.typechambre')); ?>">
                                <span class="sidebar-normal"> Catégorie Chambre </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        -->

            <li>
                <a data-toggle="collapse" href="#users">
                    <i class="fa fa-users text-right"></i>
                    <p>
                        Utilisateurs
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="users">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.client')); ?>">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="<?php echo e(route('pages.personnel')); ?>">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                        </li>
                        <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>
                            <li class="text-center">
                                <a href="<?php echo e(route('pages.getroles')); ?>">
                                    <span class="sidebar-normal"> Role & Permissions </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>

                            <li class="text-center">
                                <a class="nav-link btn-magnify" href="<?php echo e(route('pages.api')); ?>">
                                    <span>API</span></a>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </li>
            <?php if(Sentinel::getUser()->hasAnyAccess(['role.*'])): ?>

                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="<?php echo e(route('pages.log')); ?>"><i class="fa fa-globe text-right"></i>
                        <p><span>Historiques</span></p></a>
                </li>

            <?php endif; ?>
        </ul>

    </div>
</div>

