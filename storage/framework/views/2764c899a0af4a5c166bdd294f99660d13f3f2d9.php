<?php $__env->startSection('content'); ?>
    <location-partenaire></location-partenaire>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        title = `Les locations`;
        cumb = `Les offres de locations`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>