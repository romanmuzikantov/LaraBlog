@extends('layout')

@section('content')
    <form method="POST" action="{{ route('post.store') }}">
        @csrf
        
        @include('post._form')

        <button type="submit" class="btn btn-primary btn-block mt-4">Envoyer</button>
    </form>
@endsection