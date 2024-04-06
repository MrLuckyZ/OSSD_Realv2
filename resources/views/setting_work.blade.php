@extends('layouts.default')

@section('title','Home')

@section('content')
    <div class="p-0 mt-4 "  style="height:390px; width:404px">
        <h2 class="ps-4">Workspace settings</h2>
        <p class="text ps-4 mt-4" style="font-size: 20px;">Who can acess your workspace</p>
        {{-- กล่องเลือก Team --}}
        <div class="ps-4">
            <select class="form-select" aria-label="Default select example" style="width:379px; height:57px;">
                <option value="1">Only me</option>
                <option value="2">Everyonr from team</option>
                <option value="3">Anyone on the internet</option>
            </select>    
        </div>
        {{-- กล่องเชิญเข้า Team --}}
        <div class="ps-4 mt-5 ">
            <p class="text mt-4" style="font-size: 20px;">People in this workspace</p>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control me-3" id="input02" name="name" placeholder="Search by name or email" style="width: 313px; height:45px;">  
                <button style="height: 35px; width:69px; " class="btn btn-secondary" type="button">Invite</button>      
            </div>
        </div>
        {{-- ปุ่ม OK กับ BACK --}}
        <div class="ps-4 mt-5">
            <button class="btn btn-primary me-4" type="button" style="width: 69px; height: 35px;">OK</button>
            <button class="btn btn-secondary" type="button" style="width: 69px; height: 35px;">Back</button>
        </div>
    </div>
@endsection

@section('js')
@endsection
