<!DOCTYPE html>
<html>
<head>
    <title>Routine Generator</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    @yield('stylesheet')
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/stars.css')}}">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('admin') }}">Routine Generator</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ route('rooms') }}">Rooms</a></li>
        <li><a href="{{ route('teachers') }}">Teachers</a>
        <li><a href="{{ route('courses') }}">Courses</a></li>
        <li><a href="{{ route('slots') }}">Time Slot</a>
        <li><a href="{{ route('sections') }}">Sections</a></li>
        <li><a href="{{ route('days') }}">Days</a></li>
        <li><a href="{{ route('routines') }}">Routines</a></li>
        <li><a href="{{ route('users') }}">Users</a></li>
        @if(Auth::check())
        <li>
            <a href="{{route('logout')}}" class="" onclick="event.preventDefault();document.getElementById('lo').submit();">Logout</a>
            <form action="{{route('logout')}}" method="post" id="lo" style="display:none">
                {{csrf_field()}}
            </form>
        </li>
        @endif 
    </ul>
   

</nav>
</div>
<div class="wrap">
        @yield('body')
</div>
    <!-- Javascripts -->
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script>
        @if(Session::has('success'))
        toastr.success("{{Session::get('success')}}")
        @endif

        @if(Session::has('alert'))
        toastr.error("{{Session::get('alert')}}")
        @endif

        @if(count($errors) > 0)

        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}")
        @endforeach

        @endif
    </script>

    @yield('javascript')
</body>
</html>