<?php $__env->startSection('collection_template'); ?>
<div class="container-fluid p-3">
    <div class="col d-flex flex-row justify-content-between align-items-center p-0 mb-2">
        <h5><?php echo e($selectedCollection->name); ?></h5>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary d-flex align-items-center me-2" style="width: 110px; height:30px; border-radius:5px 0px 0px 5px">
                <i class="fa-regular fa-comment" style="color: #EF5B25;"></i><label for="" class="ms-1 cursor" style="font-size:14px font-weight:600; color: #EF5B25;">Comment</label>
            </button>
            <div class="d-flex align-items-center justify-content-between" style="width: 110px; height: 30px;">
                <button type="button" class="btn btn-secondary d-flex align-items-center" style="width: 80px; height: 100%; border-radius:5px 0px 0px 5px">
                        <i class="fa-regular fa-floppy-disk"></i><label for="" class="ms-1 cursor" style="font-size:14px font-weight:600;">Save</label>
                </button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" style="width:25px; height: 100%; border-radius:0px 5px 5px 0px" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Save As .json</a></li>
                    <li><a class="dropdown-item" href="#">Save As .docx</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Save to Workspace</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file" id="formFile">
        <button type="button" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;">
            <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor" style="font-size:14px font-weight:600;">Create</label>
        </button>
    </div>
</div>  
<div class="container-fluid p-3">
    <!-- Method -->
   <table class="table">
    <thead>
        <tr>
            <td class="col-2" style="">Method</td>
            <td class="col-10" style="">Route</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="col-2">
                <div class="d-flex justify-content-center">
                    <select class="form-select" aria-label="Default select example">
                        <option value="GET" selected>GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="PATCH">PATCH</option>
                        <option value="DELETE">DELETE</option>
                        <option value="HEAD">HEAD</option>
                        <option value="OPTION">OPTION</option>
                    </select>
                </div>
            </td>
            <td class="col-10">
                <input type="text" name="" id="">
            </td>
        </tr>
    </tbody>
</table>

</div>      

<?php $__env->stopSection(); ?>
<?php echo $__env->make('collection', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/OSSD_Realv2/resources/views/collection_template.blade.php ENDPATH**/ ?>