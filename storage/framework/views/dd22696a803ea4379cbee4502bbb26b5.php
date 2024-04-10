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
        <form action="<?php echo e(route('importFile', ['workspace' => $selectedWorkspace->id ,'collection'=>$selectedCollection->id])); ?>" enctype="multipart/form-data" method="POST">
            <?php echo csrf_field(); ?>
            <div class="col d-flex">
                <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file" id="file" name="file">
                <button type="submit" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;">
                    <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor"
                        style="font-size:14px font-weight:600;">Create</label>
                </button>
        
            </div>
        </form> 

    </div>
    <div class="container-fluid p-3">
        <?php
            $collection_tabs = session('collection_tabs', []);
        ?>
            <?php $__currentLoopData = $collection_tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($tabs->id == $selectedCollection->id && $tabs->method != null): ?>
            <?php
                $methods[] = $tabs->method;
            ?>
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
                                            <select class="form-select custom-textfield" aria-label="Default select example" id="method-type" name="method-type[]">
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
                                            name="method-route[]" id="method-route" placeholder="" value="<?php echo e($method->route); ?>">
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
                                        <?php
                                            $request_header[] = $method->request_header;
                                        ?>
                                        <?php $__currentLoopData = $request_header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <tr>
                                                <td class="col-1 text-center"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                    <?php echo e($loop->iteration); ?>

                                                </td>
                                                <td class="col-4"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-header-key[]" id="request-header-key" value="<?php echo e($key->key); ?>">
                                     
                                                </td>
                                                <td class="col-1"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                        <input class="form-check-input" type="checkbox" style="height: 20px; width:20px;" name="request-header-required[]" value="true" id="flexCheckDefault" <?php if($key->require): ?> checked <?php endif; ?>>

                                                    </div>
                                                </td>
                                                <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-header-desc[]" id="request-header-desc">
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                              

                                
                                <label class="mb-1" for="">Request Parameters</label>
                                <div class="table-form">
                                    <table style="width: 100%">
                                        <thead class="" style="background-color: #F2F2F2;">
                                            <tr>
                                                <td class="col-1 text-center">No</td>
                                                <td class="col-3 text-center">Key</td>
                                                <td class="col-2 text-center">Param Type</td>
                                                <td class="col-2 text-center">Data Type</td>
                                                <td class="col-1 text-center">Required</td>
                                                <td class="col-3 text-center">Description</td>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                                <?php
                                                $parameter[] = $method->parameter;
                                                ?>
                                                <?php $__currentLoopData = $parameter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="col-1 text-center"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                    <?php echo e($loop->iteration); ?>

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-param-key[]" id="request-param-key" value="<?php echo e($key->key); ?>">
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example" name="request-param-type[]">
                                                            <option value="Q" <?php if($key->type == 'Q'): ?> selected <?php endif; ?> >Q</option>
                                                            <option value="R">R</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example" name="request-param-data-type[]">
                                                            <option value="String" selected>String</option>
                                                            <option value="Number">Number</option>
                                                            <option value="Number">Booleans</option>
                                                            <option value="Number">null</option>
                                                            <option value="Number">Arrays</option>
                                                            <option value="Number">Objects</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col-1"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                        <input class="form-check-input " type="checkbox"
                                                            style="height: 20px; width:20px;" value=""
                                                            id="flexCheckDefault" name="request-param-required[]">
                                                    </div>
                                                </td>
                                                <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-param-desc[]" id="">
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="" class="mt-2">
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
                                                <td class="col-2 text-center">Data Type</td>
                                                <td class="col-2 text-center">Required</td>
                                                <td class="col-4 text-center">Description</td>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                            $request_body[] = $method->request_body;
                                            ?>
                                            <?php $__currentLoopData = $request_body; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="col-1 text-center"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                    <?php echo e($loop->iteration); ?>

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-body-key[]" id="request-body-key" value="<?php echo e($key->key); ?>">
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example" name="request-body-data-type[]">
                                                            <option value="String" selected>String</option>
                                                            <option value="Number">Number</option>
                                                            <option value="Number">Booleans</option>
                                                            <option value="Number">null</option>
                                                            <option value="Number">Arrays</option>
                                                            <option value="Number">Objects</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                        <input class="form-check-input" type="checkbox"
                                                            style="height: 20px; width:20px;" value=""
                                                            id="flexCheckDefault"
                                                            name="request-body-required[]">
                                                    </div>
                                                </td>
                                                <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="request-body-desc[]" id="">
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="" class="mt-2">
                                        <span class="material-symbols-outlined"
                                            style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                    </a>
                                </div>
                                <?php
                                    $response[] = $method->response;
                                ?>
                                <?php if(is_array($response)): ?>
                                <?php $__currentLoopData = $response; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response_body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $status[] = $response_body->status;
                                ?>
                                      
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <label class="mb-1" for="">Response Body</label>
                                    <div class="d-flex align-items-center p-0">
                                        <label class="me-2" for="">Status</label>
                                        <div class="d-flex justify-content-between">
                                            <input class="textfield text-center" type="number" name="response-body-code[]" id=""
                                                placeholder="code" value="<?php echo e($response_body['code']); ?>">
                                            <input class="textfield text-center" type="text" name="response-body-status[]" id=""
                                                placeholder="status" value="<?php echo e($response_body['status']); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-form">
                                    <table style="width: 100%">
                                        <thead class="" style="background-color: #F2F2F2;">
                                            <tr>
                                                <td class="col-1 text-center">No</td>
                                                <td class="col-3 text-center">Key</td>
                                                <td class="col-2 text-center">Data Type</td>
                                                <td class="col-6 text-center">Description</td>
                                            </tr>
                                        </thead>
                                        <?php
                                            $response_body_list = $response_body['response_body']
                                        ?>
                                        <?php $__currentLoopData = $response_body_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                        <tbody>
                                            <tr>
                                                <td class="col-1 text-center"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                    <?php echo e($loop->iteration); ?>

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="response-body-key[]" id="" value="<?php echo e($item['key']); ?>">
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example" name="response-body-data-type[]">
                                                            <option value="String" selected>String</option>
                                                            <option value="Number">Number</option>
                                                            <option value="Number">Booleans</option>
                                                            <option value="Number">null</option>
                                                            <option value="Number">Arrays</option>
                                                            <option value="Number">Objects</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                        type="text" name="response-body-desc[]" id="">
                                                </td>
                                            </tr>
                                          
                                        </tbody>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="" class="mt-2">
                                        <span class="material-symbols-outlined"
                                            style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                    </a>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                           

                              
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
              
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<script>
    $(document).ready(function() {
        $('.add-table-link').click(function(event) {
            event.preventDefault();

            // เพิ่มโค้ดสร้างตารางของคุณที่นี่
            var newTable = `
                <!-- ตารางใหม่ -->
                <div class="table-form">
                    <table style="width: 100%">
                        <!-- ส่วนหัวตาราง -->
                        <thead class="" style="background-color: #F2F2F2;">
                            <tr>
                                <td class="col-1 text-center">Header</td>
                                <!-- เพิ่มหัวคอลัมน์ตามต้องการ -->
                            </tr>
                        </thead>
                        <!-- ส่วนเนื้อหารตาราง -->
                        <tbody>
                            <tr>
                                <td class="col-1 text-center">Data</td>
                                <!-- เพิ่มเนื้อหาของคอลัมน์ตามต้องการ -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- ปุ่ม add ตาราง -->
                <div class="d-flex justify-content-end">
                    <a href="#" class="mt-2 add-table-link">
                        <span class="material-symbols-outlined"
                            style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                    </a>
                </div>
            `;

            // เพิ่มตารางใหม่ไปยังส่วนที่ต้องการแสดงผล
            $('.container-fluid.p-3').append(newTable);
        });
    });
</script>

<?php echo $__env->make('collection', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OSSD_Realv2\resources\views/collection_template.blade.php ENDPATH**/ ?>