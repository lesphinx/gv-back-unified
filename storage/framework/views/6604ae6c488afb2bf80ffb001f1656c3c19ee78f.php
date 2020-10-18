<?php $__env->startSection('title'); ?>
Edit role : <?php echo e($role->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="panel panel-default">
        <div class="panel-heading">Edit role :<?php echo e($role->name); ?> </div>

        <div class="panel-body">

    <?php echo Form::model($role, [
        'method' => 'PATCH',
        'url' => ['role', $role->id],
        'class' => 'form-horizontal'
    ]); ?>


                <div class="form-group <?php echo e($errors->has('slug') ? 'has-error' : ''); ?>">
                <?php echo Form::label('slug', 'Slug', ['class' => 'col-sm-3 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::text('slug', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('slug', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
            <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('name','Name', ['class' => 'col-sm-3 control-label']); ?>

                <div class="col-sm-6">
                    <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

                    <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            <?php echo Form::submit('Update', ['class' => 'btn btn-success form-control']); ?>

        </div>
         <a href="<?php echo e(route('role.index')); ?>" class="btn btn-default">Back</a>
    </div>
    </div>
    </div>
    <?php echo Form::close(); ?>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>