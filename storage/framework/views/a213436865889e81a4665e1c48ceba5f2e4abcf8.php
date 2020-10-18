<?php $__env->startSection('content'); ?>
    <annonce></annonce>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        title = `Annonce`;
        cumb = `Liste des Annonce`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>