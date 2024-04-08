@extends('layouts.default')

@section('title', 'Home')

@section('content')
    <div class="p-0 mt-4 " style="height:390px; width:404px">
        <h2 class="ps-4">Workspace settings</h2>
        <p class="text ps-4 mt-4" style="font-size: 20px;">Who can acess your workspace</p>
        {{-- กล่องเลือก Team --}}
        <div class="ps-4">
            <div class="d-flex">
                <select style="height:60px" name="test" id="mySelect" onchange="changeRole()">
                    <option value="onlyme">Only Me</option>
                    <option value="team">Everyone from your team</option>
                    <option value="all">Anyone on the internet</option>
                </select>

                <label id="roles" class="btn btn-outline d-flex p-0 cursor" for="public"
                    style="width:400px; height:60px;">
                    <div class="col-2 ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="me-2 mt-3" viewBox="0 0 24 24"
                            width="24" height="24">
                            <path id="icon"
                                d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1Zm3.241 10.5v-.001c-.1-2.708-.992-4.904-1.89-6.452a13.919 13.919 0 0 0-1.304-1.88L12 3.11l-.047.059c-.354.425-.828 1.06-1.304 1.88-.898 1.547-1.79 3.743-1.89 6.451Zm-12.728 0h4.745c.1-3.037 1.1-5.49 2.093-7.204.39-.672.78-1.233 1.119-1.673C6.11 3.329 2.746 7 2.513 11.5Zm18.974 0C21.254 7 17.89 3.329 13.53 2.623c.339.44.729 1.001 1.119 1.673.993 1.714 1.993 4.167 2.093 7.204ZM8.787 13c.182 2.478 1.02 4.5 1.862 5.953.382.661.818 1.29 1.304 1.88l.047.057.047-.059c.354-.425.828-1.06 1.304-1.88.842-1.451 1.679-3.471 1.862-5.951Zm-1.504 0H2.552a9.505 9.505 0 0 0 7.918 8.377 15.773 15.773 0 0 1-1.119-1.673C8.413 18.085 7.47 15.807 7.283 13Zm9.434 0c-.186 2.807-1.13 5.085-2.068 6.704-.39.672-.78 1.233-1.118 1.673A9.506 9.506 0 0 0 21.447 13Z">
                            </path>
                        </svg>
                    </div>
                    <div class="col-10 d-flex flex-column justify-content-center" style="width:250px">
                        <label id="desc" for="public" class="cursor text-center">Anyone on the internet</label>
                        <label id="type" for="public" class="cursor text-center"
                            style="color:#808080; font-size:12px;">Public</label>
                    </div>
                </label>

                <script>
                    function changeRole() {
                        var x = document.getElementById("mySelect").value;
                        var roles = document.getElementById("roles");
                        var desc = document.getElementById("desc");
                        var type = document.getElementById("type");
                        var icon = document.getElementById("icon");
                        if (x == "onlyme") {
                            desc.innerHTML = "Only Me";
                            type.innerHTML = "Personal";
                            icon.setAttribute('d',
                                "M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"
                            )
                        } else if (x == "team") {
                            desc.innerHTML = "Everyone from your team";
                            type.innerHTML = "Team";
                            icon.setAttribute('d',
                                "M3.5 8a5.5 5.5 0 1 1 8.596 4.547 9.005 9.005 0 0 1 5.9 8.18.751.751 0 0 1-1.5.045 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.499-.044 9.005 9.005 0 0 1 5.9-8.181A5.496 5.496 0 0 1 3.5 8ZM9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm8.29 4c-.148 0-.292.01-.434.03a.75.75 0 1 1-.212-1.484 4.53 4.53 0 0 1 3.38 8.097 6.69 6.69 0 0 1 3.956 6.107.75.75 0 0 1-1.5 0 5.193 5.193 0 0 0-3.696-4.972l-.534-.16v-1.676l.41-.209A3.03 3.03 0 0 0 17.29 8Z"
                            )
                        } else if (x == "all") {
                            desc.innerHTML = "Anyone on the internet";
                            type.innerHTML = "Public";
                            icon.setAttribute('d',
                                "M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1Zm3.241 10.5v-.001c-.1-2.708-.992-4.904-1.89-6.452a13.919 13.919 0 0 0-1.304-1.88L12 3.11l-.047.059c-.354.425-.828 1.06-1.304 1.88-.898 1.547-1.79 3.743-1.89 6.451Zm-12.728 0h4.745c.1-3.037 1.1-5.49 2.093-7.204.39-.672.78-1.233 1.119-1.673C6.11 3.329 2.746 7 2.513 11.5Zm18.974 0C21.254 7 17.89 3.329 13.53 2.623c.339.44.729 1.001 1.119 1.673.993 1.714 1.993 4.167 2.093 7.204ZM8.787 13c.182 2.478 1.02 4.5 1.862 5.953.382.661.818 1.29 1.304 1.88l.047.057.047-.059c.354-.425.828-1.06 1.304-1.88.842-1.451 1.679-3.471 1.862-5.951Zm-1.504 0H2.552a9.505 9.505 0 0 0 7.918 8.377 15.773 15.773 0 0 1-1.119-1.673C8.413 18.085 7.47 15.807 7.283 13Zm9.434 0c-.186 2.807-1.13 5.085-2.068 6.704-.39.672-.78 1.233-1.118 1.673A9.506 9.506 0 0 0 21.447 13Z"
                            )
                        }
                    }
                </script>
            </div>

        </div>
        {{-- กล่องเชิญเข้า Team --}}
        <div class="ps-4 mt-5 ">
            <p class="text mt-4" style="font-size: 20px;">People in this workspace</p>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control me-3" id="input02" name="name"
                    placeholder="Search by name or email" style="width: 313px; height:45px;">
                <button style="height: 35px; width:69px; " class="btn btn-secondary" type="button">Invite</button>
            </div>
        </div>
        {{-- ปุ่ม OK กับ BACK --}}
        <div class="ps-4 mt-5">
            <a href="" class="btn btn-primary me-4" type="button" style="width: 69px; height: 35px;">Ok</a>
            <a href="{{ route('workspace.collections', ['workspace' => $selectedWorkspace->id]) }}" class="btn btn-secondary"
                type="button" style="width: 69px; height: 35px;">Back</a>
        </div>
    </div>
@endsection

@section('js')
@endsection
