<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-0 mt-4 " style="height:300px;">
    <h2 class="ps-4">Recently visited workspaces</h2>
    <ul class="p-0" style="list-style-type:none;">
    <?php use Illuminate\Support\Facades\Auth; 
    $count = 0; ?>
    <?php $__currentLoopData = $work_recently; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(Auth::user()->id == $workspace->id_user): ?>
        <?php $count++; ?>
        <li class="d-flex align-items-center custom-table" style="height: 50px">
            <a class="link-black" style="width: 100%; height:100%"
                href=<?php echo e(route('workspace.index', $workspace->id_workspace)); ?>>
                <div class="col-9 d-flex align-items-center ps-4" style="height:100%">
                    <?php if($workspace->access == 'personal'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" width="24" height="18">
                            <path
                                d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z">
                            </path>
                        </svg>
                    <?php elseif($workspace->access == 'team'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="24" height="18"> 
                            <path
                                d="M3.5 8a5.5 5.5 0 1 1 8.596 4.547 9.005 9.005 0 0 1 5.9 8.18.751.751 0 0 1-1.5.045 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.499-.044 9.005 9.005 0 0 1 5.9-8.181A5.496 5.496 0 0 1 3.5 8ZM9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm8.29 4c-.148 0-.292.01-.434.03a.75.75 0 1 1-.212-1.484 4.53 4.53 0 0 1 3.38 8.097 6.69 6.69 0 0 1 3.956 6.107.75.75 0 0 1-1.5 0 5.193 5.193 0 0 0-3.696-4.972l-.534-.16v-1.676l.41-.209A3.03 3.03 0 0 0 17.29 8Z">
                            </path>
                        </svg>
                    <?php endif; ?>
                    <label label class="fs-6 fw-normal cursor" for=""><?php echo e($workspace->workspace_name); ?></label>
                </div>
                <div class="col-3 d-flex align-items-center" style="height:100%">
                    <img src="https://media.discordapp.net/attachments/994685233087643719/1215271120127791114/77ed449a829d201a7940b0f98d49ca5a3cf43dd9.jpg?ex=65fc246d&is=65e9af6d&hm=cc53b20e7bac20faa1f57f479c85b3a5c19f166a5ece6b0da943736fc79cb017&=&format=webp"
                        alt="" width="32" height="32" class="rounded-circle me-2">
                    <label class="fs-6 fw-normal mt-1 ms-2 cursor"
                        for=""><?php echo e($workspace->user_name); ?></label>
                </div>
            </a>
        </li>
    <?php endif; ?>
    <?php if($count == 5): ?> <?php break; ?> <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
    <div class="p-0 mt-4 " style="height:300px;">
        <h2 class="ps-4">Recently created workspace</h2>
        <ul class="p-0" style="list-style-type:none;">
        <?php
            $latestWorkspaces = array_reverse($workspaces);
            $count = 0;
        ?>
            <?php $__currentLoopData = $latestWorkspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(Auth::user()->id == $workspace->userCreate->id): ?>
                    <?php
                        $count++;
                    ?>
                    <li class="d-flex align-items-center custom-table" style="height: 50px">
                        <a class="link-black" style="width: 100%; height:100%"
                            href="<?php echo e(route('workspace.index', ['workspace' => $workspace->id])); ?>">
                            <div class="col-9 d-flex align-items-center ps-4" style="height:100%">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="me-2"
                                    viewBox="0 0 16 16" width="18" height="18">
                                    <path
                                        d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z">
                                    </path>
                                </svg>
                                <label label class="fs-6 fw-normal" for=""><?php echo e($workspace->name); ?></label>
                            </div>
                            <div class="col-3 d-flex align-items-center" style="height:100%">
                                <img src="https://media.discordapp.net/attachments/994685233087643719/1215271120127791114/77ed449a829d201a7940b0f98d49ca5a3cf43dd9.jpg?ex=65fc246d&is=65e9af6d&hm=cc53b20e7bac20faa1f57f479c85b3a5c19f166a5ece6b0da943736fc79cb017&=&format=webp"
                                    alt="" width="32" height="32" class="rounded-circle me-2">
                                <label class="fs-6 fw-normal mt-1 ms-2"
                                    for=""><?php echo e($workspace->userCreate->name); ?></label>
                            </div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if($count == 5): ?> <?php break; ?> <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OSAD\Click_Next2\test\OSSD_Realv2\resources\views/home.blade.php ENDPATH**/ ?>