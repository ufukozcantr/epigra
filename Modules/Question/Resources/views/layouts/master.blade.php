<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Question</title>

       {{-- Laravel Mix - CSS File --}}
       <link rel="stylesheet" href="{{ mix('css/question.css') }}">

    </head>
    <body>
        <div class='container'>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{route('question.index')}}">@lang('question::en.questions')</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('question.create')}}">@lang('question::en.create') </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('question.index')}}">@lang('question::en.list')</a>
                        </li>
                    </ul>
                </div>
            </nav>
        
            @yield('content')
        </div>

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/question.js') }}"></script>
        @yield('js')
        
    </body>
</html>
