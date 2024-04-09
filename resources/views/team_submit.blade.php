@extends('layouts.auth_default')

@section('title', 'Accept team invitation')
@section('content')
<div class="container-fluid" style="margin-top:50%">
    <div class="d-flex flex-column justify-content-center align-items-center text-center">
        <h1>Accept your team invitation</h1>
        <h4 class="mt-4">Workspace Name</h4>
        <div class="mt-4">
            <button class="btn btn-secondary me-2" type="submit" style="width: 100px; height:40px">
                Decline
            </button>
            <button class="btn btn-primary" type="submit" style="width: 100px; height:40px">
                Accept
            </button>
        </div>
    </div>
</div>


@endsection

