<?php $__env->startSection('title', 'Collection'); ?>

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
    <section class="content d-flex flex-row" style="min-height: 1200px; overflow-y: auto;">
        <!-- Collection list -->
        <div style="width: 280px; border-right: #f2f2f2 solid 1px;">
            <div class="d-flex align-items-center justify-content-between p-3"
                style="height: 55px; border-bottom: #f2f2f2 solid 1px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" width="18"
                    height="18">
                    <path
                        d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z">
                    </path>
                </svg>
                <p class="mt-3 ms-2"><?php echo e($selectedWorkspace->name); ?></p>
                <div class="dropdown p-0 ms-4">
                    <button class="btn" type="button" id="workspace_option" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="material-icons mt-2">more_horiz</span>
                    </button>
                    <ul class="dropdown-menu pane" aria-labelledby="workspace_option">
                        <li><a class="dropdown-item "
                                href="<?php echo e(route('workspace.setting', ['workspace' => $selectedWorkspace->id])); ?>">Setting</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="<?php echo e(route('workspace.deleteWorkspace', ['workspace' => $selectedWorkspace->id])); ?>">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="col d-flex align-items-center ps-0 py-2">
                    <div class="input-group">
                        <i class="fa fa-search" style="font-size: 16px; margin-top: 3px;"></i>
                        <input class="textfield"
                            style="padding-left: 35px; height:35px; width: 100%; border-radius: 5px; font-size: 14px;"
                            type="search" name="" id="" placeholder="Search collections">
                    </div>
                </div>
                <!-- Collections List -->
                <?php $__currentLoopData = $selectedWorkspace->collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($collection->status != 0): ?>
                        <div class="row">
                            <div class="col p-0 d-flex">
                                <button class="btn-collapse dropdown hover-black d-flex align-items-center"
                                    style="height: 30px; width: 100%; text-decoration:none;" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collection_<?php echo e($collection->id); ?>"
                                    aria-expanded="false" aria-controls="collection_<?php echo e($collection->id); ?>">
                                    <span class="material-symbols-outlined ms-1 me-2" name="expand"
                                        id="<?php echo e($collection->id); ?>">chevron_right</span>
                                    <span class="fs-6" style="font-weight: 500"><?php echo e($collection->name); ?></span>
                                    
                                    <button class="btn d-flex justify-content-center align-items-center mt-1"
                                        style="height: 25px;" type="button" id="workspace_option" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="material-icons">more_horiz</span>
                                    </button>
                                    <ul class="dropdown-menu pane" aria-labelledby="workspace_option">
                                        <li><a class="dropdown-item" href="#">Rename</a></li>
                                        <li><a class="dropdown-item"
                                                href="<?php echo e(Route('move.trash.collection', ['collection' => $collection->id])); ?>">Delete</a>
                                        </li>
                                    </ul>
                                </button>
                            </div>
                            <div class="collapse" id="collection_<?php echo e($collection->id); ?>"
                                <?php if(session()->has('collection_' . $collection->id . '_collapse') &&
                                        session('collection_' . $collection->id . '_collapse')): ?> aria-expanded="true" <?php endif; ?>>
                                
                                
                            </div>

                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>

        <!-- Main Content -->
        <div class="" style="width: 100%;">
            <!-- Nav Tabs -->
            <ul class="nav nav-tabs flex-row" role="tablist" style="height: 55px;">
                <?php
                    $collection_tabs = session('collection_tabs', []);
                ?>
                <?php $__currentLoopData = array_reverse($collection_tabs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-items">
                        <button class="nav-link fst-italic" role="tab" id="view_<?php echo e($collection->id); ?>"
                            data-bs-toggle="tab">
                            <?php echo e($collection->name); ?>

                            <a class="btn d-flex justify-content-center align-items-center p-1"
                                href="<?php echo e(route('delete.collection.tabs', ['workspace' => $selectedWorkspace->id, 'collection' => $collection->id])); ?>">
                                <span class="material-symbols-outlined">close</span>
                            </a>
                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a style="text-decoration: none" href="<?php echo e(route('add.new.tabs')); ?>"
                    class="d-flex justify-content-center align-items-center p-2 add-nav-items">
                    <span class="material-symbols-outlined">add</span>
                </a>
            </ul>
            <!-- Tabs Content -->
            <div class="tab-content">
                <?php echo $__env->yieldContent('collection_template'); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseList = document.querySelectorAll('.collapse');

            collapseList.forEach(function(collapse) {
                const chevron = collapse.previousElementSibling.querySelector(
                    '.material-symbols-outlined[name="expand"]');
                const id = collapse.getAttribute('id');
                const isExpanded = sessionStorage.getItem(id);

                if (isExpanded === 'true') {
                    collapse.classList.add('show');
                    chevron.textContent = 'expand_more';
                }

                collapse.addEventListener('show.bs.collapse', function() {
                    sessionStorage.setItem(id, 'true');
                    chevron.textContent = 'expand_more';
                });

                collapse.addEventListener('hide.bs.collapse', function() {
                    sessionStorage.setItem(id, 'false');
                    chevron.textContent = 'chevron_right';
                });
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            const labels = document.querySelectorAll('.navbar-nav li label:first-child');

            labels.forEach(function(label) {
                const labelText = label.textContent.trim();
                if (labelText === 'GET') {
                    label.style.color = '#34A853';
                } else if (labelText === 'POST') {
                    label.style.color = '#FF0000';
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MrLucky\Desktop\Try\OSSDProject\OSSD_Realv2\resources\views/collection.blade.php ENDPATH**/ ?>