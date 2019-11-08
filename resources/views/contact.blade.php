@extends('layout')

@section('content')
<h1>My contact !</h1>
<p>This is a contact page !</p>

@can('access-secret')
    <p>
        <a href="{{ route('secret') }}">Go to the secret page !</a>
    </p>
@endcan

@endsection