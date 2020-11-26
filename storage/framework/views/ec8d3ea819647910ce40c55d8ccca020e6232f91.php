<?php $__env->startSection('title'); ?>
Edition utilisateur
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-default">
<div class="card-body">

<div class="panel panel-default">
   <div class="panel-heading">Editer utilisateur: <?php echo e($user->name); ?></div>

     <div class="panel-body">                

    <?php echo e(Form::model($user, array('method' => 'PATCH', 'url' => route('user.update', $user->id), 'class' => 'form-horizontal', 'files' => true))); ?>

      <ul>
            <div class="row form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('first_name', 'Nom', ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::text('first_name', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('first_name', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
           
           <div class="row form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('last_name', 'Prénom' , ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::text('last_name', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('last_name', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
            <div class="row form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('email', 'Email', ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::text('email', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
            <div class="row form-group <?php echo e($errors->has('new_password') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('new_password', 'Mot de passe', ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::password('new_password', ['class' => 'form-control']); ?>

                    <?php echo $errors->first('new_password', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>

            <div class="row form-group <?php echo e($errors->has('new_password_confirmation') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('new_password_confirmation', 'Confirmation Mot de passe', ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::password('new_password_confirmation', ['class' => 'form-control']); ?>

                    <?php echo $errors->first('new_password_confirmation', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>

            <div id="role" class="row form-group <?php echo e($errors->has('role') ? 'has-error' : ''); ?>">
                 <?php echo Form::label('role','Role Utilisateur', ['class' => 'col-md-4 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::select('role', $roles, null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('role', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
           
            <div class="row form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    <?php echo Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']); ?>

                </div>
                <a href="<?php echo e(route('user.index')); ?>" class="btn btn-default">Retour liste</a>
            </div>
           

        </ul>
    <?php echo e(Form::close()); ?>

    </div>
    </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>