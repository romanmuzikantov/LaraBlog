<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Contact</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark d-flex flex-row border-bottom shadow-sm align-items-baseline">
        <div class="mr-auto"><a class="navbar-brand" href="{{ route('home') }}">Laravel Blog</a></div>
        
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                

                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.index') }}">Blog Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.create') }}">Add</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" 
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout ({{ Auth::user()->name }})
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <div class="container pt-4">
        @if (session()->has('status'))
            <p style="color:cadetblue">
                {{ session()->get('status') }}
            </p>
        @endif
        @yield('content')
    </div>
    

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>