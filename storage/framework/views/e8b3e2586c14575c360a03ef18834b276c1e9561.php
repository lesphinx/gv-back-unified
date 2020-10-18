<?php $__env->startSection('content'); ?>

    <personnellist></personnellist>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        window.axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
        };
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>