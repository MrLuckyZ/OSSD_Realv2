@extends('layouts.default')

@section('title', 'Home')

@section('content')
<div class="mt-5 text-center">
    <h2 class="text-center">View Profile</h2>
    <div class="container mb-3" style="position: relative;">
        <img class="mt-4" style="width: 280px; height: 280px; border-radius: 50%;" src="{{url('/assets/icon/cat.png')}}" alt="" class="rounded-circle me-2">
        <button class="btn p-0" style="border:none; top: 85%; left: 56%; position:absolute;" href="{{route('view_profile', ['id' => $id])}}">
            <svg style="" width="45" height="45" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="27" cy="27" r="27" fill="#EF5B25"/>
                <path d="M40 20.8115C40.001 20.6404 39.9682 20.4708 39.9035 20.3125C39.8388 20.1541 39.7435 20.01 39.623 19.8886L34.111 14.377C33.9895 14.2565 33.8455 14.1612 33.6871 14.0965C33.5287 14.0318 33.3591 13.999 33.188 14C33.0169 13.999 32.8473 14.0318 32.6889 14.0965C32.5305 14.1612 32.3865 14.2565 32.265 14.377L28.586 18.0557L14.377 32.2637C14.2565 32.3851 14.1612 32.5292 14.0965 32.6875C14.0318 32.8459 13.999 33.0155 14 33.1866V38.6982C14 39.0429 14.137 39.3736 14.3808 39.6173C14.6246 39.8611 14.9552 39.9981 15.3 39.9981H20.812C20.9939 40.008 21.1759 39.9795 21.3461 39.9146C21.5163 39.8496 21.6709 39.7497 21.8 39.6211L35.931 25.4132L39.623 21.7994C39.7416 21.6735 39.8383 21.5285 39.909 21.3705C39.9215 21.2669 39.9215 21.1621 39.909 21.0585C39.9151 20.998 39.9151 20.937 39.909 20.8765L40 20.8115ZM20.279 37.3983H16.6V33.7195L29.509 20.8115L33.188 24.4902L20.279 37.3983ZM35.021 22.6574L31.342 18.9786L33.188 17.1458L36.854 20.8115L35.021 22.6574Z" fill="white"/>
            </svg>
        </button>    
    </div>
    <form action="{{route('edit_profile', ['user' => $user])}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="d-flex align-items-center justify-content-center mt-5">
            <label for="" class="me-3 " style="font-size: 20px">Name</label>
            <input type="text" class="form-control" name="name" placeholder="{{$user->name}}" style="width: 251px; height: 45px;" name>    
        </div>
        <div class="mt-5">
            <button class="btn btn-primary me-4" type="submit" style="width: 69px; height: 35px;">SAVE</button>
            <button onclick="history.back()" class="btn btn-secondary" type="btn" style="width: 69px; height: 35px;">BACK</button>
        </div>
    </form>
</div>
@endsection

@section('js')
@endsection
