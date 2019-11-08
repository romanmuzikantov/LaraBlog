@extends('layout')

@section('content')
    <div class="row">
        <div class="col-8 pr-4">
            <div class="pb-4">
                <h1 class="d-inline">{{ $post['title'] }}</h1>
                <p class="badge badge-pill text-primary d-inline p-0">{{ Cache::get($counterKey, 0) }} visiteur(s)</p>
                <p class="mb-0"><i>Créé {{ $post->created_at->locale('fr_FR')->diffForHumans() }}</i></p>
            </div>
            
            <div class="bg-white p-3 mb-3 rounded-lg shadow-sm">
                <p>{{ $post['content'] }}</p>
                <p class="font-weight-bold mb-0">
                    <i>Créé le {{ $post->created_at->locale('fr_FR')->isoFormat('DD/MM/YYYY à HH:MM') }} par {{ $post->user->name }}</i>
                </p>
            </div>
            
            @tags(['tags' => $post->tags])
            @endtags
            <div class="pt-3">
                <h4 class="pb-2">Comments</h4>
                @auth
                    @include('comments._form')
                @else
                    <p class="text-muted"><a href="{{ route('login') }}">Connectez vous</a> pour envoyer un commentaire !</p>
                @endauth
                <hr>
                @forelse ($post->comments as $comment)
                    @comment(['comment' => $comment])
                    @endcomment
                @empty
                    No comment yet!
                @endforelse
            </div>
        </div>
        <div class="col-4">
            @include('post._sideNav')
        </div>
    </div>
    
@endsection