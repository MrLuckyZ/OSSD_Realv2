

<?php $__env->startSection('title', 'Accept team invitation'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="margin-top:50%">
    <div class="d-flex flex-column justify-content-center align-items-center text-center">
        <h1>Accept your team invitation</h1>
        <h4 class="mt-4">Workspace Name</h4>
        <div class="mt-4">
            

            <form action="<?php echo e(route('invitation.confirm.post')); ?>" method="POST">
                <?php echo csrf_field(); ?> 
                <input type="text" name="token" hidden value="<?php echo e($token); ?>">
            <button class="btn btn-primary" type="submit" style="width: 100px; height:40px">
                Accept
            </button>
        </form>
        <a href="<?php echo e(route('login')); ?>">
            <button  class="btn btn-secondary me-2" type="submit" style="width: 100px; height:40px">
                Decline
            </button>
          </a>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth_default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OSSD_Realv2\resources\views/TeamInviteComfirm.blade.php ENDPATH**/ ?>