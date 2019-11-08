@extends('layout')

@section('content')
<form method="POST" action="{{ route('post.update', ['id' => $post->id]) }}">
        @csrf
        @method('PUT')
        
        @include('post._form')

        <button type="submit">Update</button>
    </form>
@endsection