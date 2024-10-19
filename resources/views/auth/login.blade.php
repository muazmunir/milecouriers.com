@extends('layouts.guest')
@section('content')
<div class="login-card login-dark">
    <div>
        <div><a class="logo" href="index.html"><img class="img-fluid for-dark" src="/backend/assets/images/logo/logo.png" alt="looginpage"><img class="img-fluid for-light" src="/backend/assets/images/logo/logo_dark.png" alt="looginpage"></a></div>
        <div class="login-main">

            <!-- Bootstrap alert for errors (validation/authentication messages) -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Bootstrap alert for success (if needed, can be removed if not required) -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="theme-form" method="POST" action="{{ route('login') }}">
                @csrf
                <h4>Sign in to account</h4>
                <p>Enter your email & password to login</p>

                <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" required="" placeholder="Test@gmail.com" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                        <input class="form-control" type="password" name="password" required="" placeholder="*********">
                        <!-- <div class="show-hide"> <span class="show"></span></div> -->
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="checkbox p-0">
                        <input id="checkbox1" type="checkbox" name="remember">
                        <label class="text-muted" for="checkbox1">Remember password</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif

                    <div class="text-end mt-3">
                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                    </div>
                </div>

                <!-- 
                <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                <div class="social mt-4">
                    <div class="btn-showcase">
                        <a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank">
                            <i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn
                        </a>
                        <a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank">
                            <i class="txt-twitter" data-feather="twitter"></i> Twitter
                        </a>
                        <a class="btn btn-light" href="https://www.facebook.com/" target="_blank">
                            <i class="txt-fb" data-feather="facebook"></i> Facebook
                        </a>
                    </div>
                </div>
                <p class="mt-4 mb-0 text-center">Don't have an account?<a class="ms-2" href="sign-up.html">Create Account</a></p>
                -->
            </form>
        </div>
    </div>
</div>
@endsection
