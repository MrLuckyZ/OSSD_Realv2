@extends('collection')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

@section('collection_template')
    <div class="container-fluid p-3">
        <div class="col d-flex flex-row justify-content-between align-items-center p-0 mb-2">
            <h5>{{ $selectedCollection->name }}</h5>
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
                        <li>
                            <button onclick="submitForm(event)" id="save-json" class="dropdown-item" type="button">Save As json</button>
                        </li>
                        <li><a class="dropdown-item" href="#">Save As .docx</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button onclick="submitForm(event)" id="save-workspace" class="dropdown-item" type="button">Save to Workspace</button></li>

                    </ul>
                </div>
            </div>
        </div>
        <form action="{{ route('importFile', ['workspace' => $selectedWorkspace->id ,'collection'=>$selectedCollection->id]) }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="col d-flex">
                <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file" id="file" name="file">
                <button type="submit" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;">
                    <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor"
                        style="font-size:14px font-weight:600;">Create</label>
                </button>
        
            </div>
        </form> 

    </div>
    <form action="{{route('workspace.toJson', ['workspace' => $selectedWorkspace->id])}}" name="form-data" id="form-data" method="POST">
        @csrf
        <div class="container-fluid p-3">
            @php
                $collection_tabs = session('collection_tabs', []);
            @endphp
                @foreach ($collection_tabs as $tabs)
                @if($tabs->id == $selectedCollection->id && $tabs->method != null)
                @php
                    $methods[] = $tabs->method;
                @endphp
                    @foreach ($methods as $method)
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
                                                name="method-route[]" id="method-route" placeholder="" value="{{$method->route}}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- ปุ่ม pup --}}
                        <div class="mb-3">
                            <button class="btn p-0" style="background-color: white;" type="button" data-bs-toggle="collapse"
                                data-bs-target="#TestExample" aria-expanded="false" aria-controls="TestExample">
                                <span id="dropdown-nav-icon" class="material-icons" style="color: #EF5B25">chevron_right</span>
                            </button>
                            <div class="collapse" id="TestExample">
                                <div class="card card-body mt-3" style="border: none;">
                                    {{-- ตาราง Request Headers --}}
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
                                            {{-- ข้อมูลของ Request Headers --}}
                                            <tbody>
                                            @php
                                                $request_header[] = $method->request_header;
                                            @endphp
                                            @foreach ($request_header as $item)
                                            @foreach ($item as $key)
                                                
                                                <tr>
                                                    <td class="col-1 text-center"
                                                        style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="col-4"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request-header-key[]" id="request-header-key" value="{{$key->key}}">
                                         
                                                    </td>
                                                    <td class="col-1"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                            <input class="form-check-input" type="checkbox" style="height: 20px; width:20px;" name="request-header-required[]" value="true" id="flexCheckDefault" @if($key->require) checked @endif>
    
                                                        </div>
                                                    </td>
                                                    <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request-header-desc[]" id="request-header-desc">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                  
    
                                    {{-- ตาราง Request Parameters --}}
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
                                            {{-- ข้อมูลของ Request Parameters --}}
                                            <tbody>
                                                <tr>
                                                    @php
                                                    $parameter[] = $method->parameter;
                                                    @endphp
                                                    @foreach ($parameter as $item)
                                                    @foreach ($item as $key)
                                                    <td class="col-1 text-center"
                                                        style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="col-3"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request-param-key[]" id="request-param-key" value="{{ $key->key }}">
                                                    </td>
                                                    <td class="col-2"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="d-flex justify-content-center">
                                                            <select class="form-select custom-textfield"
                                                                aria-label="Default select example" name="request-param-type[]">
                                                                <option value="Q" @if ($key->type == 'Q') selected @endif >Q</option>
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
                                                @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="" class="mt-2">
                                            <span class="material-symbols-outlined"
                                                style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                        </a>
                                    </div>
    
                                    {{-- ตาราง Request Body --}}
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
                                            {{-- ข้อมูลของ Request Body --}}
                                            <tbody>
                                                @php
                                                $request_body[] = $method->request_body;
                                                @endphp
                                                @foreach ($request_body as $item)
                                                @foreach ($item as $key)
                                                <tr>
                                                    <td class="col-1 text-center"
                                                        style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="col-3"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request-body-key[]" id="request-body-key" value="{{$key->key}}">
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
                                                @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="" class="mt-2">
                                            <span class="material-symbols-outlined"
                                                style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                        </a>
                                    </div>
                                    @php
                                        $response[] = $method->response;
                                    @endphp
                                    @if(is_array($response))
                                    @foreach ($response as $response_body)
                                    @php
                                        $status[] = $response_body->status;
                                    @endphp
                                          {{-- ตาราง Response Body --}}
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <label class="mb-1" for="">Response Body</label>
                                        <div class="d-flex align-items-center p-0">
                                            <label class="me-2" for="">Status</label>
                                            <div class="d-flex justify-content-between">
                                                <input class="textfield text-center" type="number" name="response-body-code[]" id=""
                                                    placeholder="code" value="{{$response_body['code']}}">
                                                <input class="textfield text-center" type="text" name="response-body-status[]" id=""
                                                    placeholder="status" value="{{$response_body['status']}}">
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
                                            @php
                                                $response_body_list = $response_body['response_body']
                                            @endphp
                                            @foreach ($response_body_list as $item)
                                                {{-- ข้อมูลของ Response Body --}}
                                            <tbody>
                                                <tr>
                                                    <td class="col-1 text-center"
                                                        style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="col-3"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="response-body-key[]" id="" value="{{$item['key']}}">
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
                                            @endforeach
                                            
                                        </table>
                                    </div>
    
                                    <div class="d-flex justify-content-end">
                                        <a href="" class="mt-2">
                                            <span class="material-symbols-outlined"
                                                style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                               
    
                                  
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                  
                @endforeach
        </div>
    </form>
@endsection
<script>
    function submitForm(event) {
        const id = event.target.id
        const form = $('#form-data')
        
        if (id == "save-json") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('workspace.saveJson', ['workspace' => $selectedWorkspace->id]) }}",
                type: 'POST',
                data: form,
                contentType: 'application/json',
                success: function(res) {
                    window.open(res)
                }
            })
        } else {
            const formData = document.getElementById('form-data')
            console.log(1)
            if (form) {
                formData.submit()
            }
        }  
    }

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
