<?php $__env->startSection('title'); ?>
    <?php echo e($role->is_group ?"Group permissions":"Role permissions"); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-default">
        <div class="card-heading"><?php echo e($role->is_group ?"Group ":"Role "); ?><?php echo e($role->name); ?></div>
        <div class="card-body">

            <?php echo e(Form::open(array('url' => route('role.save', $role->id), 'class' => 'form-horizontal'))); ?>

            <ul>
                <div class="row">
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <?php $first = array_values($action)[0];
                            $firstname = explode(".", $first)[0];
                            ?>

                            <?php echo e(Form::label($firstname, $firstname, ['class' => 'form col-md-2 capital_letter'])); ?>

                            <select name="permissions[]" class="select" multiple="multiple">
                                <?php $__currentLoopData = $action; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(explode(".", $act)[0]=="api"): ?>
                                        <option value="<?php echo e($act); ?>" <?php echo e(array_key_exists($act, $role->permissions)?"selected":""); ?>>
                                            <?php echo e(isset(explode(".", $act)[2])?explode(".", $act)[1].".".explode(".", $act)[2]:explode(".", $act)[1]); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo e($act); ?>" <?php echo e(array_key_exists($act, $role->permissions)?"selected":""); ?>>

                                            <?php echo e(explode(".", $act)[1]); ?>


                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-3">
                            <?php echo Form::submit('Enregistrer', ['class' => 'btn btn-success form-control']); ?>

                        </div>
                        <div class="col-sm-offset-3 col-sm-3">
                            <a href="<?php echo e($role->is_group ? route('group.index'):route('role.index')); ?>"
                               class="btn btn-default form-control"><< Liste</a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    </ul>
    <?php echo e(Form::close()); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(URL::asset('select/jquery.sumoselect.js')); ?>"></script>
    <link href="<?php echo e(URL::asset('select/sumoselect.css')); ?>" rel="stylesheet"/>

    <script type="text/javascript">
        $('.select').SumoSelect({selectAll: true, placeholder: 'Nothing selected'});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>