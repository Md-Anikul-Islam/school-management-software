{{--<x-guest-layout>--}}
{{--    <div class="mb-4 text-sm text-gray-600">--}}
{{--        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}--}}
{{--    </div>--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}
{{--    <form method="POST" action="{{ route('password.email') }}">--}}
{{--        @csrf--}}
{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}
{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            <x-primary-button>--}}
{{--                {{ __('Email Password Reset Link') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}


<!DOCTYPE html>
<html lang="en" data-bs-theme="pink">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/fontawsome/css/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/fontawsome/fonts/iconly/iconly.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/fontawsome/fonts/lineicons/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/css/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}" />
</head>

<body>
<section class="login">
    <div class="login-group py-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10 ">
                    <div class="card p-4">
                        <div class="d-flex  flex-column justify-content-center align-items-center">
                            <center>
                                <img max-width='80' src="{{URL::to('frontend/assets/images/logo/logo.png')}}" />
                            </center>
                            <h4 class="mt-3">iNiLabs School</h4>
                        </div>

                        <div class="login-form m-0" id="login-box">
                            <h5 class="header text-center mt-3 mb-3">Reset Password.</h5>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label required">Your Email</label>
                                    <input class="form-control" placeholder="Email" name="email" type="text">
                                </div>
                                <button type="submit" class="btn btn-inline">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- All Js File -->
<script src="{{asset('frontend/assets/js/vendor/jquery-3.6.4.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/jquery.appear.js')}}"></script>
<script src="{{asset('frontend/assets/js/odometer.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('frontend/assets/js/owl.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/initialize.js')}}"></script>
<script src="{{asset('frontend/assets/js/script.js')}}"></script>
<script src="{{asset('frontend/assets/js/custom.js')}}"></script>
</body>

</html>

