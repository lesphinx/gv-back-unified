<?php $__env->startSection('title'); ?>
New user role
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div>
       <div class="col-md-12">

                 <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    <span class="badge badge-pill badge-errot">Error</span>
   <?php echo e($error); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>


                    <?php if(session()->has('success')): ?>
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    <span class="badge badge-pill badge-success">Success</span>
    <?php echo e(session()->get('success')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
         </div>
<?php endif; ?>
    <?php if(session()->has('error')): ?>
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
    <span class="badge badge-pill badge-errot">Error</span>
    <?php echo e(session()->get('error')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
    <?php endif; ?>
               </div>
</div>
<div class="card card-primary">
  <div class="card-title">Nouveau Role</div>
<div class="card-body">
  <?php echo Form::open(['url' => 'role', 'class' => 'form-horizontal']); ?>

          <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
              <?php echo Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']); ?>

              <div class="col-sm-6">
                  <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

                  <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

              </div>
          </div>
  <div class="form-group">
      <div class="row">
        <div class="col-sm-offset-3 col-sm-3">
            <?php echo Form::submit('Créer', ['class' => 'btn btn-success form-control']); ?>

        </div>
        <div class="col-sm-offset-3 col-sm-3">
          <a href="<?php echo e(route('role.index')); ?>" class="btn btn-default"><< Retour</a>

        </div>
      </div>
  </div>

  <?php echo Form::close(); ?>

    </div>
    </div>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>