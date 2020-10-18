<?php $__env->startSection('content'); ?>
    <clientlist></clientlist>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        title = `Clients`;
        cumb = `Liste des client`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);
      
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>