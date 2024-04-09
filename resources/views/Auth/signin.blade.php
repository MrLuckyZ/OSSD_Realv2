@extends('layouts.auth_default')

@section('title', 'Sign In your account')
@section('content')
    <div class="header mt-2 ms-2">
        <img src="https://cdn.discordapp.com/attachments/994685233087643719/1217121151285985350/clicknext_logo.png?ex=6602df67&is=65f06a67&hm=9b903fcb7daa77f74eb6166e5ecf0b998078316cf21d431e1dad8a376caa6082&"
            alt="" width="155px">
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="alert alert-error" role="alert">
        {{ Session::get('error') }}
    </div>
    <div class="col d-flex flex-column align-items-center">
        <form action="{{ route('login') }}" method="POST"
            class="body d-flex flex-column justify-center align-items-center needs-validation"
            style="width: 310px; margin-top: 20%;" novalidate>
            @csrf
            <label for="" class="mb-4" style="font-size: 32px;">Sign in your account</label>
            <div class="input-group mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon me-2 mt-2" viewBox="0 0 16 16"
                    width="18" height="18">
                    <path
                        d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z">
                    </path>
                </svg>
                <input class="textfield form-control"
                    style="padding-left: 40px; height: 45px; width: 100%; border-radius: 5px;" type="email" name="email"
                    id="email" placeholder="Enter your email" required>
                <div class="invalid-feedback">Please fill your email.</div>
            </div>
            <div class="input-group mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon me-2 mt-2" viewBox="0 0 16 16"
                    width="16" height="16">
                    <path
                        d="M4 4a4 4 0 0 1 8 0v2h.25c.966 0 1.75.784 1.75 1.75v5.5A1.75 1.75 0 0 1 12.25 15h-8.5A1.75 1.75 0 0 1 2 13.25v-5.5C2 6.784 2.784 6 3.75 6H4Zm8.25 3.5h-8.5a.25.25 0 0 0-.25.25v5.5c0 .138.112.25.25.25h8.5a.25.25 0 0 0 .25-.25v-5.5a.25.25 0 0 0-.25-.25ZM10.5 6V4a2.5 2.5 0 1 0-5 0v2Z">
                    </path>
                </svg>
                <input class="textfield form-control"
                    style="padding-left: 40px; height: 45px; width: 100%; border-radius: 5px;" type="password"
                    name="password" id="password" placeholder="Enter your password" required>
                <i class="bi bi-eye-slash icon" style="margin-left: 85%; margin-top: 6px;" id="password-icon"
                    onclick="togglePasswordVisibility('password', 'password-icon')">
                    <input type="checkbox" name="" id="password-visibility" class="visually-hidden">
                </i>
                <div class="invalid-feedback">Please fill your password.</div>
            </div>
            <div class="d-flex p-0 mb-3" style="width: 100%;">
                <div class="col d-flex align-items-center">
                    <label class="checkbox me-2 mt-1">
                        <input type="checkbox" class="checkbox__input" id="remember" />
                        <span class="checkbox__inner"></span>
                    </label>
                    <label for="remember" style="font-weight: 400; font-size: 14px; color: #808080;">Remember me</label>
                </div>
                <div class="col d-flex align-items-center">
                    <a class="link-grey" style="font-size: 14px; font-weight:400;" href="{{ route('forgot') }}">Forgot your
                        password?</a>
                </div>
            </div>
            <button class="btn btn-primary" style="font-weight:400; height: 45px;" type="submit">Sign In</button>
            <div class="d-flex justify-content-center align-items-center mt-4 mb-4" style="width: 100%">
                <div class="line"></div>
                <div class="mx-2" style="color: #808080;">or</div>
                <div class="line"></div>
            </div>
            <p class="mb-4" style="font-size: 14px; font-weight:400; color: #808080;">Don't have an account yet?</p>
            <a class="link-primary" href="{{ route('signup') }}">Create an account</a>
        </form>
    </div>
@endsection

@section('js')
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        function togglePasswordVisibility(inputId, iconId) {
            var checkbox = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            var passwordField = document.getElementById(inputId);
            if (checkbox.checked) {
                icon.classList.replace('bi-eye', 'bi-eye-slash');
                passwordField.setAttribute('type', 'password');
            } else {
                icon.classList.replace('bi-eye-slash', 'bi-eye');
                passwordField.setAttribute('type', 'text');
            }
            checkbox.checked = !checkbox.checked;
        }
    </script>
@endsection
