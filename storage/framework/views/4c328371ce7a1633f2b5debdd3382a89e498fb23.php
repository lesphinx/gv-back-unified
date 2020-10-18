<?php $__env->startSection('title'); ?>
User role
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-primary">
<div class="card-body">
    <a href="<?php echo e(url('role/create')); ?>" class="btn btn-success"><h6> + role</h6></a>
    <div class="table">
        <table class="table table-bordered table-striped table-hover" id="tblroles">
            <thead>
                <tr>
                    <th>ID</th><th>Nom</th><th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->id); ?></td>
                    <td><a href="<?php echo e(url('role', $item->id)); ?>"><?php echo e($item->name); ?></td>
                    <td>
                        <a href="<?php echo e(url('role/' . $item->id . '/edit')); ?>" class="btn btn-success btn-xs">Editer</a>
                        <a href="<?php echo e(url('role/' . $item->id . '/permissions')); ?>" class="btn btn-warning btn-xs">Permissions</a> 
                        <?php echo Form::open([
                            'method'=>'DELETE',
                            'url' => ['role', $item->id],
                            'style' => 'display:inline'
                        ]); ?>

                            <?php echo Form::submit('Supprimer', ['class' => 'btn btn-danger btn-xs deleteconfirm']); ?>

                        <?php echo Form::close(); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblroles').DataTable({
                columnDefs: [{
                    targets: [0],
                    visible: false,
                    searchable: false
                    },
                ],
                order: [[0, "asc"]],
            });
        });
     $(".deleteconfirm").on("click", function(){
            return confirm("Are you sure to delete this Role");
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>