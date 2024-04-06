

<?php $__env->startSection('title','Home'); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-4" style="height:100%; width:100%">
        <h1>Your Workspaces</h1>
        
        <div class="d-flex  mt-4">
            <div class="input-group" style="width: 220px; height:35px; ">
                <i class="fa fa-search " style="font-size: 14px; margin-top: 4.5px;"></i>
                <div>
                    <input type="search" class="form-control me-3 rounded-2" style="width: 211px; height:35px; " placeholder="Search workspaces">
                </div>
            </div>
            
            <select class="form-select me-3 link-grey" style="width: auto; height:35px;">
                <option selected>Visibility</option>
            </select>
            <select class="form-select me-3 link-grey" style="width: auto; height:35px;">
                <option selected>Created by</option>
            </select>
            <select class="form-select ms-auto link-grey" style="width: auto; height:35px;">
                <option selected >Sort by A to Z</option>
            </select> 
        </div>
        <div class="mt-3">
            <ul class="p-0" style="list-style-type:none;">
                <?php $__currentLoopData = $workspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($index < 5): ?>
                    <li class="d-flex align-items-center custom-table" style="height: 50px">
                        <a class="link-black" style="width: 100%; height:100%" href="<?php echo e(route('workspace.index', ['workspace' => $workspace->id])); ?>">
                            <div class="col-9 d-flex align-items-center ps-4" style="height:100%">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="me-2" viewBox="0 0 16 16" width="18" height="18"><path d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z"></path></svg>
                                <label label class="fs-6 fw-normal cursor" for=""><?php echo e($workspace->name); ?></label>
                            </div>
                            <div class="col-3 d-flex align-items-center" style="height:100%">
                                <img src="https://media.discordapp.net/attachments/994685233087643719/1215271120127791114/77ed449a829d201a7940b0f98d49ca5a3cf43dd9.jpg?ex=65fc246d&is=65e9af6d&hm=cc53b20e7bac20faa1f57f479c85b3a5c19f166a5ece6b0da943736fc79cb017&=&format=webp" alt="" width="32" height="32" class="rounded-circle me-2">
                                <label class="fs-6 fw-normal mt-1 ms-2 cursor" for=""><?php echo e($workspace->userCreate->name); ?></label>
                            </div>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>    
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OSSD_Realv2\resources\views/all_work.blade.php ENDPATH**/ ?>