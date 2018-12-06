
@extends('layouts.apps')
@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @endauth
            </div>
        @endif
        <div class="content">
            <div class="title m-b-md">
               Routine Generator
            </div>
            <div class="form">
                <form>
                </form>
        <div class="login-form">
<form  method="POST" action="{{ route('login') }}">
{{csrf_field()}}
    <h2 class="text-center">Log in</h2>       
    <div class="form-group">
        <input id="IdentityNumber" type="text" class="form-control" name="email" v required autofocus>
    </div>
    <div class="form-group">
        <input id="password" type="password" class="form-control" name="password" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Log in</button>
    </div>       
</form>
</div>
</div>
    </div>
@endsection