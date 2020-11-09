<?php $__env->startSection('title'); ?>
Create user
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <div class="panel panel-default">
        <div class="panel-heading">Créer Utilisateur</div>

        <div class="panel-body">

        <?php if(count($errors) > 0): ?>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="alert alert-danger">
                            <strong>Upsss !</strong> Il ya une erreure...<br /><br />
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

<?php echo e(Form::open(array('url' => route('user.store'), 'class' => 'form-horizontal','files' => true))); ?>

    <ul>
        <div class="form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
             <?php echo Form::label('first_name', 'Nom', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::text('first_name', null, ['class' => 'form-control']); ?>

                <?php echo $errors->first('first_name', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>
       
       <div class="form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
             <?php echo Form::label('last_name', 'Prénom' , ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::text('last_name', null, ['class' => 'form-control']); ?>

                <?php echo $errors->first('last_name', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>
        <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
             <?php echo Form::label('email', 'Email', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::text('email', null, ['class' => 'form-control']); ?>

                <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>
        <div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
             <?php echo Form::label('password', 'Mot de Passe', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::password('password', ['class' => 'form-control']); ?>

                <?php echo $errors->first('password', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>

        <div class="form-group <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
             <?php echo Form::label('password_confirmation', 'Confirmation Mot de Passe', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::password('password_confirmation', ['class' => 'form-control']); ?>

                <?php echo $errors->first('password_confirmation', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>

        <div id="role" class="form-group <?php echo e($errors->has('role') ? 'has-error' : ''); ?>">
             <?php echo Form::label('role','Role utilisateur', ['class' => 'col-md-4 control-label']); ?>

            <div class="col-sm-6">
                <?php echo Form::select('role', $roles, null, ['class' => 'form-control']); ?>

                <?php echo $errors->first('role', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>
       
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                <?php echo Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']); ?>

            </div>
            <a href="<?php echo e(route('user.index')); ?>" class="btn btn-default">Liste utilisateurs</a>
        </div>
       

    </ul>
  
<?php echo e(Form::close()); ?>


  </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>