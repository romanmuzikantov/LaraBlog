@extends('layout')

@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
            @if ($errors->has('password'))
                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" value="{{ old('remember') ? 'checked' : '' }}">
                <label class="form-check-label" for="remember">Remember me ?</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection