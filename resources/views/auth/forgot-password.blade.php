@extends('layouts.guest')
@section('content')
<div class="login-card login-dark">
    <div>
        <div><a class="logo" href="index.html"><img class="img-fluid for-dark" src="/backend/assets/images/logo/logo.png" alt="looginpage"><img class="img-fluid for-light" src="/backend/assets/images/logo/logo_dark.png" alt="looginpage"></a></div>
        <div class="login-main">
            <!-- Bootstrap alert for status (success message) -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Bootstrap alert for errors (error messages) -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <h4>Reset your account</h4>
                <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" required="" placeholder="Test@gmail.com">
                </div>

                <div class="form-group mb-0">
                    <div class="text-end mt-3">
                        <button class="btn btn-primary btn-block w-100" type="submit">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </div>
                <p class="mt-4 mb-0 text-center">Already have an password?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
            </form>
        </div>
    </div>
</div>
@endsection
