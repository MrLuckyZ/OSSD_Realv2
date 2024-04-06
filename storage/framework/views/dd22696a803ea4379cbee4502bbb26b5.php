

<?php $__env->startSection('collection_template'); ?>

<h5><?php echo e($selectedCollection->name); ?></h5>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('collection', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OSSD_Realv2\resources\views/collection_template.blade.php ENDPATH**/ ?>