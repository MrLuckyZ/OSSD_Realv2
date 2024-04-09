@extends('layouts.default')

@section('title', 'Trash')

@section('sidebar')
    <a href="{{ route('workspace.collections', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white btn-menu @if (request()->routeIs('workspace.collections')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">folder</span>
        <label class="fw-normal cursor" style="color: white" for="">Collections</label>
    </a>
    <a href="{{ route('workspace.history', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white  btn-menu @if (request()->routeIs('workspace.history')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">manage_history</span>
        <label class="fw-normal cursor" style="color: white" for="">History</label>
    </a>
    <a href="{{ route('workspace.trash', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white  btn-menu @if (request()->routeIs('workspace.trash')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">delete</span>
        <label class="fw-normal cursor" style="color: white" for="">Trash</label>
    </a>
@endsection

@section('content')
    <div class="p-0 mt-4 " style="height:300px;">
        <h2 class="ps-4">Trash</h2>
        <p class="ms-4">
            Collections you delete will show up here. You can restore or permanently delete them.
        </p>
        <ul class="p-0" style="list-style-type:none;">
            <div class="col">
                <div class="d-flex align-items-centern" style="height: 50px">
                    <div class="col d-flex align-items-center">
                        <label class="ms-4">Collection name</label>
                    </div>
                    <div class="col d-flex align-items-center">
                        <label class="ms-6">Delete time</label>
                    </div>
                    <div class="col d-flex align-items-center">
                        <label class="ms-5">Action</label>
                    </div>
                </div>
                @foreach ($selectedWorkspace->collections as $collection)
                @if ($collection->status != 1)
                        <div class="d-flex align-items-center" style="height: 50px ; border-top:#f2f2f2 solid 1px">
                            <div class="col d-flex align-items-center">
                                <label class="ms-4">{{$collection->name}}</label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label class="ms-6">{{$collection->deleted_at}}</label>
                            </div>
                            <div class="col d-flex align-items-center">
                                <label class="ms-4">
                                    <div class="dropdown p-0 ms-4">
                                        <button class="btn" type="button" id="trash_option" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <span class="material-icons mt-2">more_horiz</span>
                                        </button>
                                        <ul class="dropdown-menu pane p-1 align-items-center" style="width:150px" aria-labelledby="workspace_option">
                                            <li><a style="width: 100%" class="btn btn-danger mb-1 delete-collection-FR-btn
                                                
                                                " href="{{Route('delete.collection',['collection' => $collection->id])}}">Delete</a></li>
                                            <li><a style="width: 100%" class="btn btn-success" href="{{Route('recovery.trash',['collection' => $collection->id])}}">Recover</a></li>
                                            <li><a style="width: 100%" class="btn btn-secondary mb-1" href="#">Cancel</a></li>
                    
                                        </ul>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </ul>
    </div>
    <script>
         // Select the delete button
         const deleteBtn = document.querySelector('.delete-collection-FR-btn');
    
    // Add a click event listener to the delete button
    deleteBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the link

        // Show the SweetAlert2 confirmation dialog
        Swal.fire({
            title: "Are you sure to delete this Collection Forever?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            // If the user confirms the deletion
            if (result.isConfirmed) {
                // Redirect to the delete workspace route
                window.location.href = deleteBtn.getAttribute('href');
            }
        });
    });
    </script>
@endsection

@section('js')
@endsection
