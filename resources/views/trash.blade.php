@extends('layouts.default')

@section('title','Trash')

@section('sidebar')
<a href="{{route('workspace.collections',['workspace' => $selectedWorkspace->id])}}" class="list-group-items hover-white btn-menu @if(request()->routeIs('workspace.collections')) focus @endif" style="text-decoration: none;">
    <span class="material-symbols-outlined" style="font-size: 36px;">folder</span>
    <label class="fw-normal cursor" style="color: white" for="">Collections</label>
</a>
<a href="{{route('workspace.history',['workspace' => $selectedWorkspace->id])}}" class="list-group-items hover-white  btn-menu @if(request()->routeIs('workspace.history')) focus @endif" style="text-decoration: none;">
    <span class="material-symbols-outlined" style="font-size: 36px;">manage_history</span>
    <label class="fw-normal cursor" style="color: white" for="">History</label>
</a>
<a href="{{route('workspace.trash',['workspace' => $selectedWorkspace->id])}}" class="list-group-items hover-white  btn-menu @if(request()->routeIs('workspace.trash')) focus @endif" style="text-decoration: none;">
    <span class="material-symbols-outlined" style="font-size: 36px;">delete</span>
    <label class="fw-normal cursor" style="color: white" for="">Trash</label>
</a>
@endsection

@section('content')
Trash
@endsection

@section('js')
@endsection
