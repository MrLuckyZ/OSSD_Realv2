<?php $__env->startSection('collection_template'); ?>
    <div class="container-fluid p-3">
        <div class="col d-flex flex-row justify-content-between align-items-center p-0 mb-2">
            <h5><?php echo e($selectedCollection->name); ?></h5>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary d-flex align-items-center me-2"
                    style="width: 110px; height:30px; border-radius:5px 0px 0px 5px">
                    <i class="fa-regular fa-comment" style="color: #EF5B25;"></i><label for="" class="ms-1 cursor"
                        style="font-size:14px font-weight:600; color: #EF5B25;">Comment</label>
                </button>
                <div class="d-flex align-items-center justify-content-between" style="width: 110px; height: 30px;">
                    <button type="button" class="btn btn-secondary d-flex align-items-center"
                        style="width: 80px; height: 100%; border-radius:5px 0px 0px 5px">
                        <i class="fa-regular fa-floppy-disk"></i><label for="" class="ms-1 cursor"
                            style="font-size:14px font-weight:600;">Save</label>
                    </button>
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                        style="width:25px; height: 100%; border-radius:0px 5px 5px 0px" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Save As .json</a></li>
                        <li><a class="dropdown-item" href="#">Save As .docx</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Save to Workspace</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col d-flex">
            <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file"
                id="formFile">
            <button type="button" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;">
                <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor"
                    style="font-size:14px font-weight:600;">Create</label>
            </button>
        </div>
    </div>
    <div class="container-fluid p-3">
        <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Method -->
            <div class="table-form">
                <table style="width: 100%">
                    <thead class="" style="background-color: #F2F2F2;">
                        <tr>
                            <td class="col-2 text-center">Method</td>
                            <td class="col-10 text-center">Route</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-2"
                                style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2; border-radius:5px;">
                                <div class="d-flex justify-content-center">
                                    <select class="form-select custom-textfield" aria-label="Default select example">
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
                            <td class="col-2 " style="border-top: 2px solid #F2F2F2; border-radius:5px;">
                                <input class="mt-1 custom-textfield" style="height: auto; width: 100%;" type="text"
                                    name="" id="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            
            <div class="mb-3">
                <button class="btn p-0" style="background-color: white;" type="button" data-bs-toggle="collapse"
                    data-bs-target="#TestExample" aria-expanded="false" aria-controls="TestExample">
                    <span id="dropdown-nav-icon" class="material-icons" style="color: #EF5B25">chevron_right</span>
                </button>
                <div class="collapse" id="TestExample">
                    <div class="card card-body mt-3" style="border: none;">
                        
                        <label class="mb-1" for="">Request Headers</label>
                        <div class="table-form">
                            <table style="width: 100%">
                                <thead class="" style="background-color: #F2F2F2;">
                                    <tr>
                                        <td class="col-1 text-center">No</td>
                                        <td class="col-4 text-center">Key</td>
                                        <td class="col-1 text-center">Required</td>
                                        <td class="col-6 text-center">Description</td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr>
                                        <td class="col-1"
                                            style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                        </td>
                                        <td class="col-4"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                        <td class="col-1"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    style="height: 20px; width:20px;" value=""
                                                    id="flexCheckDefault">
                                            </div>
                                        </td>
                                        <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="">
                                <span class="material-symbols-outlined"
                                    style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                            </a>
                        </div>

                        
                        <label class="mb-1" for="">Request Parameters</label>
                        <div class="table-form">
                            <table style="width: 100%">
                                <thead class="" style="background-color: #F2F2F2;">
                                    <tr>
                                        <td class="col-1 text-center">No</td>
                                        <td class="col-3 text-center">Key</td>
                                        <td class="col-2 text-center">Param Type</td>
                                        <td class="col-2 text-center">Date Type</td>
                                        <td class="col-1 text-center">Required</td>
                                        <td class="col-3 text-center">Description</td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr>
                                        <td class="col-1"
                                            style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                        </td>
                                        <td class="col-3"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                        <td class="col-2"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="d-flex justify-content-center">
                                                <select class="form-select custom-textfield"
                                                    aria-label="Default select example">
                                                    <option value="Q" selected>Q</option>
                                                    <option value="P">P</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="col-2"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="d-flex justify-content-center">
                                                <select class="form-select custom-textfield"
                                                    aria-label="Default select example">
                                                    <option value="String" selected>String</option>
                                                    <option value="Int">Int</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="col-1"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                <input class="form-check-input " type="checkbox"
                                                    style="height: 20px; width:20px;" value=""
                                                    id="flexCheckDefault">
                                            </div>
                                        </td>
                                        <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="">
                                <span class="material-symbols-outlined"
                                    style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                            </a>
                        </div>

                        
                        <label class="mb-1" for="">Request Body</label>
                        <div class="table-form">
                            <table style="width: 100%">
                                <thead class="" style="background-color: #F2F2F2;">
                                    <tr>
                                        <td class="col-1 text-center">No</td>
                                        <td class="col-3 text-center">Key</td>
                                        <td class="col-2 text-center">Date Type</td>
                                        <td class="col-2 text-center">Required</td>
                                        <td class="col-4 text-center">Description</td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr>
                                        <td class="col-1"
                                            style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                        </td>
                                        <td class="col-3"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                        <td class="col-2"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="d-flex justify-content-center">
                                                <select class="form-select custom-textfield"
                                                    aria-label="Default select example">
                                                    <option value="String" selected>String</option>
                                                    <option value="Int">Int</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="col-2"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    style="height: 20px; width:20px;" value=""
                                                    id="flexCheckDefault">
                                            </div>
                                        </td>
                                        <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="">
                                <span class="material-symbols-outlined"
                                    style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                            </a>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <label class="mb-1" for="">Request Body</label>
                            <div class="d-flex align-items-center p-0">
                                <label class="me-2" for="">Status</label>
                                <div class="d-flex justify-content-between">
                                    <input class="textfield text-center" type="text" name="" id=""
                                        placeholder="status">
                                    <input class="textfield text-center" type="number" name="" id=""
                                        placeholder="code">
                                </div>
                                <button class="btn" style="border: 2px solid #F2F2F2;">
                                    <span class="material-symbols-outlined mt-1 fs-6" style="">expand_more</span>
                                </button>
                            </div>
                        </div>
                        <div class="table-form">
                            <table style="width: 100%">
                                <thead class="" style="background-color: #F2F2F2;">
                                    <tr>
                                        <td class="col-1 text-center">No</td>
                                        <td class="col-3 text-center">Key</td>
                                        <td class="col-2 text-center">Date Type</td>
                                        <td class="col-6 text-center">Description</td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr>
                                        <td class="col-1"
                                            style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                        </td>
                                        <td class="col-3"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                        <td class="col-2"
                                            style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                            <div class="d-flex justify-content-center">
                                                <select class="form-select custom-textfield"
                                                    aria-label="Default select example">
                                                    <option value="String" selected>String</option>
                                                    <option value="Int">Int</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                            <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                type="text" name="" id="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="">
                                <span class="material-symbols-outlined"
                                    style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('collection', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MrLucky\Desktop\Try\OSSDProject\OSSD_Realv2\resources\views\collection_template.blade.php ENDPATH**/ ?>