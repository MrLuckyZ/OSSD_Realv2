@extends('collection')
@section('collection_template')
<form id="form-data" action="" method="POST" enctype="multipart/form-data">           
    @csrf
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
                    <button type="button" class="btn btn-secondary d-flex align-items-center" onclick="saveToCollection()"
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
                            <button type="submit" class="dropdown-item" onclick="saveAsJson()">Save As .Json</button>
                        </li>
                        <li>
                            <button type="submit" class="dropdown-item" onclick="saveAsDocx()">Save As .docx</button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="submit"  class="dropdown-item" onclick="saveToCollection()">Save to Workspace</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="col d-flex">
                <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file" id="file" name="file">
                <button type="button" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;" onclick="createData()">
                    <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor"
                        style="font-size:14px font-weight:600;">Create</label>
                </button>
        
            </div>

    </div>
 
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
                                                <select class="form-select custom-textfield" aria-label="Default select example" id="method_type" name="method_type[]">
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
                                                name="method_route[]" id="method-route" placeholder="" value="{{$method->route}}">
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
                                                            type="text" name="request_header_key[]" id="request_header_key" value="{{$key->key}}">
                                         
                                                    </td>
                                                    <td class="col-1"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="form-check d-flex justify-content-center align-items-center mt-1">
                                                            <input class="form-check-input" type="checkbox" style="height: 20px; width:20px;" name="request_header_required[]" value="true" id="flexCheckDefault" @if($key->require) checked @endif>
    
                                                        </div>
                                                    </td>
                                                    <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request_header_desc[]" id="request-header-desc">
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
                                                            type="text" name="request_param_key[]" id="request_param_key" value="{{ $key->key }}">
                                                    </td>
                                                    <td class="col-2"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="d-flex justify-content-center">
                                                            <select class="form-select custom-textfield"
                                                                aria-label="Default select example" name="request_param_type[]">
                                                                <option value="Q" @if ($key->type == 'Q') selected @endif >Q</option>
                                                                <option value="R">R</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="col-2"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="d-flex justify-content-center">
                                                            <select class="form-select custom-textfield"
                                                                aria-label="Default select example" name="request_param_data_type[]">
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
                                                                id="flexCheckDefault" name="request_param_required[]">
                                                        </div>
                                                    </td>
                                                    <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request_param_desc[]" id="">
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
                                                            type="text" name="request_body_key[]" id="request_body_key" value="{{$key->key}}">
                                                    </td>
                                                    <td class="col-2"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="d-flex justify-content-center">
                                                            <select class="form-select custom-textfield"
                                                                aria-label="Default select example" name="request_body_data_type[]">
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
                                                                name="request_body_required[]">
                                                        </div>
                                                    </td>
                                                    <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                                            type="text" name="request_body_desc[]" id="">
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
                                                <input class="textfield text-center" type="number" name="response_body_code[]" id=""
                                                    placeholder="code" value="{{$response_body['code']}}">
                                                <input class="textfield text-center" type="text" name="response_body_status[]" id=""
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
                                                            type="text" name="response_body_key[]" id="" value="{{$item['key']}}">
                                                    </td>
                                                    <td class="col-2"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div class="d-flex justify-content-center">
                                                            <select class="form-select custom-textfield"
                                                                aria-label="Default select example" name="response_body_data_type[]">
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
                                                            type="text" name="response_body_desc[]" id="">
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
    function createData() {
        document.getElementById('form-data').action = '{{route('importFile', ['workspace' => $selectedWorkspace->id,'collection' => $selectedCollection])}}';
        document.getElementById('form-data').submit();
    }
    function saveToCollection() {
        document.getElementById('form-data').action = '{{route('workspace.toWorkspace', ['workspace' => $selectedWorkspace->id])}}';
        document.getElementById('form-data').submit();
    }
    function saveAsDocx() {
        document.getElementById('form-data').action = '{{route('workspace.toJson', ['workspace' => $selectedWorkspace->id])}}';
        document.getElementById('form-data').submit();
    }
    function saveAsJson() {
        document.getElementById('form-data').action = '{{route('workspace.toJson', ['workspace' => $selectedWorkspace->id])}}';
        document.getElementById('form-data').submit();
    }
</script>