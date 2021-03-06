<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gvoyage</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(Sentinel::check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>">Accueil</a>
                        <?php echo Form::open(['url' => url('logout'),'class'=>'form-inline']); ?>

                           <?php echo csrf_field(); ?>

                          <button class="btn btn-primary btn-lg btn-block register-button" type="submit" >Logout</button>
                       <?php echo Form::close(); ?>

                       
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>">Connexion</a>
                        <a href="<?php echo e(url('/register')); ?>">Créer compte</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    Gvoyage accueil backend
                    
                </div>
                <?php if(Sentinel::check() ): ?>
                     Nom : <?php echo e(Sentinel::getUser()->first_name); ?> <br>
                     Prénom : <?php echo e(Sentinel::getUser()->last_name); ?> <br>
                     E-mail : <?php echo e(Sentinel::getUser()->email); ?> <br>
                    <?php endif; ?>

                <div class="links">
                    <a href="http://technomegapartners.com">Tweeter TMP</a>
                    <a href="http://technomegapartners.com">Site TMP</a>
                    <a href="http://technomegapartners.com">Facebook TMP</a>
                </div>
            </div>
        </div>
    </body>
</html>
