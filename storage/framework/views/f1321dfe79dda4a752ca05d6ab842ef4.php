<?php $__env->startSection('title', 'History'); ?>

<?php $__env->startSection('sidebar'); ?>
    <a href="<?php echo e(route('workspace.collections', ['workspace' => $selectedWorkspace->id])); ?>"
        class="list-group-items hover-white btn-menu <?php if(request()->routeIs('workspace.collections')): ?> focus <?php endif; ?>"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">folder</span>
        <label class="fw-normal cursor" style="color: white" for="">Collections</label>
    </a>
    <a href="<?php echo e(route('workspace.history', ['workspace' => $selectedWorkspace->id])); ?>"
        class="list-group-items hover-white  btn-menu <?php if(request()->routeIs('workspace.history')): ?> focus <?php endif; ?>"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">manage_history</span>
        <label class="fw-normal cursor" style="color: white" for="">History</label>
    </a>
    <a href="<?php echo e(route('workspace.trash', ['workspace' => $selectedWorkspace->id])); ?>"
        class="list-group-items hover-white  btn-menu <?php if(request()->routeIs('workspace.trash')): ?> focus <?php endif; ?>"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">delete</span>
        <label class="fw-normal cursor" style="color: white" for="">Trash</label>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    History
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MrLucky\Desktop\Try\OSSDProject\OSSD_Realv2\resources\views\history.blade.php ENDPATH**/ ?>