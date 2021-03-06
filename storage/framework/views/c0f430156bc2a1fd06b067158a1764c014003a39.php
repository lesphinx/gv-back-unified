<?php echo $__env->make('cdn.css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body class="bg-blue" id="body" style="color:black;background-color:white; background-repeat:no-repeat; background-attachment: fixed;
  background-size: 100% 100%; " background="storage/sites/image.jpg">
    <div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
      <div class="col-xl-5 col-lg-6 col-md-10">
        <div class="card">

          <div class="card-header bg-primary" >

     
            <div class="app-brand">
              <a href="#">
                <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                  viewBox="0 0 30 33">
                  <g fill="none" fill-rule="evenodd">
                    <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                    <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                  </g>
                </svg>
                <span class="text-dark">Gvoyage</span>
              </a>
            </div>
          </div>
          <div class="card-body p-5" >

            <h4 class="text-dark mb-5">Connexion </h4>
            <?php echo e(Form::open(array('url' => route('login'), 'class' => 'form-horizontal form-signin','files' => true))); ?>    
             
            <?php if(Session::has('message')): ?>
            <div class="alert alert-<?php echo e((Session::get('status')=='error')?'danger':Session::get('status')); ?> " alert-dismissable fade in id="sessions-hide">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong><?php echo e(Session::get('status')); ?>!</strong> <?php echo Session::get('message'); ?>

              </div>
               <?php endif; ?>

              <?php if($errors->has('global')): ?>
                  <div class="sufee-danger alert with-close alert-danger alert-dismissible fade show">
                      <span class="badge badge-pill badge-errot">Erreur</span>
                      <strong><?php echo e($errors->first('global')); ?></strong>

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              <?php endif; ?>


              <?php echo csrf_field(); ?>

            <div class="form-group  mb-4 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                <div class="col-sm-12">
                    <?php echo Form::text('email', null, ['class' => 'form-control  input-lg','placeholder '=>'E-mail']); ?>

                    <?php echo $errors->first('email', '<p class="help-block text-danger">:message</p>'); ?>

                </div>
            </div>
            <div class="form-group  mb-4 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                <div class="col-sm-12">
                     <?php echo Form::password('password', ['class' => 'form-control  input-lg','placeholder '=>'Password']); ?>

                    <?php echo $errors->first('password', '<p class="help-block text-danger">:message</p>'); ?>

                </div>
            </div>      
           
            <button class="btn btn-lg btn-primary btn-block mb-4"  name="Submit" value="Login" type="Submit">Connexion</button>
    

        
          </div>
        </div>
      </div>
    </div>
  
  </div>
</body>
<?php echo $__env->make('cdn.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
