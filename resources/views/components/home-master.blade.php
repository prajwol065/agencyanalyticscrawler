<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Agent Anaytics Crawler</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="{{ secure_asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('css/app.css')}}" rel="stylesheet"> --}}
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: black;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .nav-link {
            color: white;

        }

        .nav-link:hover {
            color: white;
            font-style: italic;
        }

        .navbar {
            margin-bottom: 10px;
        }

        table#dataTable {
            margin-left: 205px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">


        <div class="content">
            <div class="title m-b-md">
                Agency Anaytics Crawler
            </div>

            <nav class="navbar navbar-expand-lg bg-primary">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('webcrawl.store') }}">Start Crawling <i
                                    class="fa fa-paint-brush"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('webcrawl.index') }}">Page Summary <i
                                    class="fa fa-book-open"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('webcrawl.show') }}">Overall Summary <i
                                    class="fa fa-eye"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('image.show') }}">Unique Images <i
                                    class="fa fa-image"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="justify-content-center">
                @yield('content')
            </div>

        </div>
    </div>
    <script src="{{ secure_asset('vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('vendor/fontawesome-free/js/all.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
