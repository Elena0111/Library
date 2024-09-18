<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('titolo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- Fogli di stile -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/@yield('stile')">
    <!-- Icone Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- jQuery e plugin JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/js/myScript.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light rounded" aria-label="Thirteenth navbar example">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand col-lg-3 me-0" href="#">&nbsp;</a>
            <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                <ul class="navbar-nav col-lg-6">
                    @yield('left_navbar')
                </ul>
                <ul class="nav navbar-nav navbar-right">
                @if($logged)
                    <li><i>{{ trans('labels.welcome') }} {{ $loggedName }}</i> <a class="btn btn-outline-dark" href="{{ route('user.logout') }}">{{ trans('labels.logout') }} <i class="bi-box-arrow-left"></i></a></li>
                    @else
                    <li><a class="btn btn-outline-dark" href="{{ route('user.login') }}"><i class="bi-door-open-fill"></i> {{ trans('labels.login') }}</a></li>
                @endif
                <a href="{{ route('setLang', ['lang' => 'en']) }}" class="nav-link"><img src="{{ url('/') }}/img/flags/en.png" width="30" class="img-rounded"/></a>
                <a href="{{ route('setLang', ['lang' => 'it']) }}" class="nav-link"><img src="{{ url('/') }}/img/flags/it.png" width="24" class="img-rounded"/></a>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('breadcrumb')
    </div>

    <div class="container">
        <header class="header-sezione">
            <h1>
                @yield('titolo')
            </h1>
        </header>
    </div>
    
    <div class="container">
        @yield('corpo')
    </div>
</body>

</html>