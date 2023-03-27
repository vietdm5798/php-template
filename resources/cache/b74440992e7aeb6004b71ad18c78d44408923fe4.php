<?php $__env->startSection('content'); ?>
    <h2>test</h2>
    <?php
        echo $aa;
    ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/test.blade.php ENDPATH**/ ?>