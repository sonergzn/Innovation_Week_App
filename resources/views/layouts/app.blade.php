<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EhbDefendersBlog') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href=" {{ asset('css/tailwind.css') }}" rel="stylesheet">
    <link href=" {{ asset('css/unreset.css') }}" rel="stylesheet">
    <link href=" {{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Quill stylesheet -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <header class="bg-gray-800 py-6">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'EhbDefendersBlog') }}
                    </a>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    <a class="no-underline hover:underline" href="/"> Home </a>
                    <!-- <a class="no-underline hover:underline" href="/blog"> Blog </a> -->

                    <a class="no-underline hover:underline" href="{{ URL::temporarySignedRoute('posts.index', now()->addMinutes(30)) }}"> Blog </a>

                    @if (Auth::Check())
                        <a class="no-underline hover:underline" href="{{ URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30)) }}">Workspace</a>
                    @endif

                    @if (Auth::Check())
                        <a class="no-underline hover:underline" href="{{route('user.page.index')}}"> MyProfile </a>
                    @else

                    @endif

                    @if (Auth::Check() && Auth::User()->isadmin == 1)
                        <a class="no-underline hover:underline" href="{{route('admin.index')}}"> Admin Page </a>
                    @else

                    @endif

                    @guest
                        <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <span>{{ Auth::user()->name }}</span>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </nav>
            </div>
        </header>
        <div>
            @yield('content')
        </div>

        <div>
            @include('layouts.footer')
        </div>

    </div>
</body>
</html>
