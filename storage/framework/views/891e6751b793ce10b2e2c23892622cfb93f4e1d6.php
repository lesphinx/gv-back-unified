<?php $__env->startSection('title'); ?>
Détail de  <?php echo e($user->first_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-default">
<div class="card-body">

<div class="panel panel-default">
        <div class="panel-heading">L'Utlisateur :  <?php echo e($user->first_name); ?></div>

        <div class="panel-body">
  
 <ul>
        <div class="row">
             <?php echo Form::label('first_name','Nom', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo e($user->first_name); ?>

            </div>
        </div>
       
       <div class="row">
             <?php echo Form::label('last_name', 'Prénom', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
               <?php echo e($user->last_name); ?>

            </div>
        </div>

        <div class="row">
             <?php echo Form::label('email', 'Email', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
               <?php echo e($user->email); ?>

            </div>
        </div>

         <div class="row">
             <?php echo Form::label('role', 'Role', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo e($user->roles->first()->name); ?>

            </div>
        </div>
    
        <div class="row">
        <br>
        <div class="col-md-6 col-md-offset-4">
            <a href="<?php echo e(route('user.index')); ?>" class="btn btn-default">Retour </a>
            </div>
        </div>
    </ul>
    </div>
    </div>                
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>