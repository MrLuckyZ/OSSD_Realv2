@extends('collection')

@section('collection_template')
    <div class="container-fluid p-3">
        <div class="col d-flex flex-row justify-content-between align-items-center p-0 mb-2">
            <h5>{{ $selectedCollection->name }}</h5>
            <div class="d-flex justify-content-between">
                <div style="display: flex; flex-direction: column; align-items: center;">

                    <!-- Comment button -->
                    <button type="button" onclick="showComment()"
                        class="btn btn-secondary d-flex align-items-center me-2 comment_button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"
                        id="openComment">
                        <i class="fa-regular fa-comment" style="color: #EF5B25;"></i><label for=""
                            class="ms-1 cursor" style="font-size:14px font-weight:600; color: #EF5B25;">Comment</label>
                    </button>

                    <!-- Comment DIV -->
                    <div class="collapse card position-fixed comment_card" id="commentPage">
                        <div class="card-body">
                            <div>
                                <button class="comment_close_button me-2" onclick="closeComment()" id="closeComment">
                                    <i class="bi bi-x-lg"> </i>
                                </button>
                            </div>
                            <h5>GET</h5>
                            <h6>Comments</h6>
                            <div style="height: 490px">

                            </div>
                            <div>
                                <input style="width: 265px" type="text" placeholder=" Add a new comment">
                                <button class="btn btn-primary btn-sm mt-2 me-3" style="right: 0; position: fixed;"
                                    type="submit">Comment</button>
                            </div>
                        </div>
                    </div>

                </div>
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
        <form
            action="{{ route('importFile', ['workspace' => $selectedWorkspace->id, 'collection' => $selectedCollection->id]) }}"
            enctype="multipart/form-data" method="POST">
            @csrf
            <div class="col d-flex">
                <input class="form-control me-2" style="border: #F2F2F2 solid 2px; color:#808080;" type="file"
                    id="file" name="file">
                <button type="submit" class="btn btn-blue d-flex align-items-center" style="width: 100px; height: 100%;">
                    <i class="fa-regular fa-file-lines"></i><label for="" class="ms-1 cursor"
                        style="font-size:14px font-weight:600;">Create</label>
                </button>

            </div>
        </form>

    </div>
    <div class="container-fluid p-3">
        @php
            $collection_tabs = session('collection_tabs', []);
        @endphp
        @foreach ($collection_tabs as $tabs)
            @if ($tabs->id == $selectedCollection->id && $tabs->method != null)
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
                                            <select class="form-select custom-textfield"
                                                aria-label="Default select example">
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
                                        <input class="mt-1 custom-textfield" style="height: auto; width: 100%;"
                                            type="text" name="" id="" placeholder="{{ $method->route }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- ปุ่ม pup --}}
                    <div class="mb-3">
                        <button class="btn p-0" style="background-color: white;" type="button" data-bs-toggle="collapse"
                            data-bs-target="#TestExample" aria-expanded="false" aria-controls="TestExample">
                            <span id="dropdown-nav-icon" class="material-icons"
                                style="color: #EF5B25">chevron_right</span>
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
                                            {{ $method->request_header[0] }}
                                            @php
                                                $request_header[] = $method->request_header;
                                            @endphp
                                            @foreach ($request_header as $item)
                                                <tr>
                                                    <td class="col-1"
                                                        style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                                    </td>
                                                    <td class="col-4"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield"
                                                            style="height: auto; width: 100%;" type="text"
                                                            name="" id="" value="">
                                                    </td>
                                                    <td class="col-1"
                                                        style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                        <div
                                                            class="form-check d-flex justify-content-center align-items-center mt-1">
                                                            <input class="form-check-input" type="checkbox"
                                                                style="height: 20px; width:20px;" value=""
                                                                id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="col-6" style="border-top: 2px solid #F2F2F2;">
                                                        <input class="mt-1 custom-textfield"
                                                            style="height: auto; width: 100%;" type="text"
                                                            name="" id="">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="">
                                        <span class="material-symbols-outlined"
                                            style="background-color: #F2F2F2; color: #000000; border-radius: 5px;">add</span>
                                    </a>
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
                                                <td class="col-1"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
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
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center mt-1">
                                                        <input class="form-check-input " type="checkbox"
                                                            style="height: 20px; width:20px;" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                </td>
                                                <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
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
                                            <tr>
                                                <td class="col-1"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example">
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
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center mt-1">
                                                        <input class="form-check-input" type="checkbox"
                                                            style="height: 20px; width:20px;" value=""
                                                            id="flexCheckDefault">
                                                    </div>
                                                </td>
                                                <td class="col-3" style="border-top: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
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
                                {{-- ตาราง Response Body --}}
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <label class="mb-1" for="">Response Body</label>
                                    <div class="d-flex align-items-center p-0">
                                        <label class="me-2" for="">Status</label>
                                        <div class="d-flex justify-content-between">
                                            <input class="textfield text-center" type="text" name=""
                                                id="" placeholder="status">
                                            <input class="textfield text-center" type="number" name=""
                                                id="" placeholder="code">
                                        </div>
                                        <button class="btn" style="border: 2px solid #F2F2F2;">
                                            <span class="material-symbols-outlined mt-1 fs-6"
                                                style="">expand_more</span>
                                        </button>
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
                                        {{-- ข้อมูลของ Response Body --}}
                                        <tbody>

                                            <tr>
                                                <td class="col-1"
                                                    style="border-right: 2px solid #F2F2F2; border-top: 2px solid #F2F2F2;">

                                                </td>
                                                <td class="col-3"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
                                                </td>
                                                <td class="col-2"
                                                    style="border-top: 2px solid #F2F2F2; border-right: 2px solid #F2F2F2;">
                                                    <div class="d-flex justify-content-center">
                                                        <select class="form-select custom-textfield"
                                                            aria-label="Default select example">
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
                                                    <input class="mt-1 custom-textfield"
                                                        style="height: auto; width: 100%;" type="text" name=""
                                                        id="">
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
                @endforeach
            @endif
        @endforeach
    </div>
    <script>
        function showComment() {
            var x = document.getElementById('commentPage');
            x.classList.toggle('show');
        }

        function closeComment() {
            var y = document.getElementById('commentPage');
            y.classList.toggle('show');
        }
    </script>
@endsection
