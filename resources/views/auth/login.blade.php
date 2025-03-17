{{--<x-guest-layout>--}}
{{--    <!-- Session Status -->--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--    <form method="POST" action="{{ route('login') }}">--}}
{{--        @csrf--}}

{{--        <!-- Email Address -->--}}
{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="current-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Remember Me -->--}}
{{--        <div class="block mt-4">--}}
{{--            <label for="remember_me" class="inline-flex items-center">--}}
{{--                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">--}}
{{--                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--            </label>--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            <x-primary-button class="ms-3">--}}
{{--                {{ __('Log in') }}--}}
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
    <div class="login-group justify-content-center align-items-center">
        <div class="login-content">
            <h3>welcome back!</h3>
            <p>Please login to your account</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label required">Email</label>
                    <input class="form-control" placeholder="Enter your mail" name="email" type="email" autofocus
                           value="">
                </div>
                <div class="form-group">
                    <label class="form-label required">Password</label>
                    <input class="form-control" placeholder="Password" name="password" type="password">
                </div>
                <div class="checkbox d-flex align-items-center justify-content-between">
                    <label class="mb-2">
                        <input type="checkbox" value="Remember Me" name="remember">
                        <span> &nbsp; Remember Me</span>
                    </label>
                    <span class="pull-right">
                            <label>
                                <a class="mb-2 forgotPass" href="{{route('password.request')}}">Forgot Password?</a>
                            </label>
                        </span>
                </div>

                <button type="submit" class="btn btn-inline">sign in</button>
            </form>

        </div>


        <div class="login-banner">
            <img src="{{URL::to('frontend/assets/images/login/loginn.jpg')}}" alt="login">
            <div>
                <blockquote>“Education is the most powerful weapon which can use to change the world.”</blockquote>
                <label>--Nelson Mandela</label>
            </div>
        </div>

    </div>
</section>
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
