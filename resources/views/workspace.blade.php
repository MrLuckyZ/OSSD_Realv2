@extends('layouts.default')

@section('title', 'Workspace')

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
        <h2 class="ps-4">Test Export Section</h2>
        <form action="{{ route('home.exportfile') }}" method="POST">
            @csrf
            <input type="file" name="json_file" id="json_file">
            <button type="submit">Export to Word</button>
        </form>

        <form action="{{ route('home.exportfile') }}" method="POST">
            @csrf
            <input class="mt-2" type="text" name="id" id="id"><br>
            <input class="mt-2" type="text" name="name" id="name"><br>
            <input class="mt-2" type="text" name="email" id="email"><br>
            <input class="mt-2" type="text" name="address" id="address"><br>
            <button type="submit">Submit</button>
        </form>
    </div>
@endsection

@section('js')
@endsection
