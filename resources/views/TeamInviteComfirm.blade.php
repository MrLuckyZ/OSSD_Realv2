@extends('layouts.auth_default')

@section('title', 'Accept team invitation')
@section('content')
<div class="container-fluid" style="margin-top:50%">
    <div class="d-flex flex-column justify-content-center align-items-center text-center">
        <h1>Accept your team invitation</h1>
        <h4 class="mt-4">Workspace name: {{$workspace->name}}</h4>
        <div class="mt-4">
            

            <form action="{{ route('invitation.confirm.post') }}" method="POST">
                @csrf 
                <input type="text" name="token" hidden value="{{$token}}">
                <div class="d-flex">
                    <button class="btn btn-primary me-2" type="submit" style="width: 100px; height:40px">
                        Accept
                    </button>
                    <a href="{{ route('login') }}"  class="btn btn-secondary me-2" type="submit" style="width: 100px; height:40px">
                        Decline
                    </a>
                </div>
        </form>
        </div>
    </div>
</div>


@endsection