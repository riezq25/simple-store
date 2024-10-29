@extends('layouts.auth')

@section('content')
    <h4 class="mb-1">Adventure starts here 🚀</h4>
    <p class="mb-6">Make your app management easy and fun!</p>

    @include('layouts.partials.error-message')

    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-6">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" autofocus
                value="{{ old('name') }}" />
        </div>

        <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                autofocus value="{{ old('email') }}" />
        </div>
        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password_confirmation">Password Confirmation</label>
            <div class="input-group input-group-merge">
                <input type="password_confirmation" id="password_confirmation" class="form-control"
                    name="password_confirmation" aria-describedby="password_confirmation" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>

        <button class="btn btn-primary d-grid w-100">Sign up</button>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
@endsection
