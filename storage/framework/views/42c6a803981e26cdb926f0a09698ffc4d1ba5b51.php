<?php $__env->startSection('content'); ?>
    <index-voyage></index-voyage>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        title = `Voyages`;
        cumb = `Les offres de Voyage`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>