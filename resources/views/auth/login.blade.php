<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{asset('./css/style.css')}}">
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>

<body>
    @include('sweetalert::alert')
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-4">
                        <div class="card-body login">
                            <a href="{{URL('/')}}"><img src="{{asset('./assets/logo.png')}}"
                                    class="logo_login_and_register mb-3" alt="" srcset=""></a>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="username"
                                            class="form-control-sm col-form-label text-md-end">username</label>
                                        <input id="username" type="text"
                                            class="form-control form-control-sm @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}" required autocomplete="username"
                                            autofocus>
                                    </div>

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="password"
                                            class="form-control-sm col-form-label text-md-end">Password</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control form-control-sm @error('password') is-invalid @enderror"
                                            required autocomplete="current-password">
                                    </div>
                                </div>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label for="company"
                                            class="form-control-sm col-form-label text-md-end">Select Company</label>
                                        <select name="company" id="" class="form-controlform-control-sm">
                                            <option value="bpu">BPU</option>
                                            <option value="skb">SKB</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn-init btn-submit">
                                            {{ __('Login') }}
                                        </button>

                                        <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
