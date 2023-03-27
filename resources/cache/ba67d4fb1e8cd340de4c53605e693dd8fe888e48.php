<?php $__env->startSection('content'); ?>
    <h3>home</h3>
    <?php
        echo $bb;
    ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/home.blade.php ENDPATH**/ ?>