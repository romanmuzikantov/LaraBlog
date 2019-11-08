@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
            <div class="pb-5">
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="{{ $post->trashed() ? 'text-muted' : '' }}">
                        {{ $post->title }}
                    </a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>
                <p class="text-muted">
                    Ajouté {{ $post->created_at->locale('FR_fr')->diffForHumans() }} par {{ $post->user->name }}
                </p>
                @tags(['tags' => $post->tags])
                @endtags
                @if ($post->comments_count)
                    <p>{{ $post->comments_count }} commentaires</p>
                @else
                    <p>Pas encore de commentaires</p>
                @endif
                @auth
                    @can('update', $post)
                        <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="btn btn-primary d-inline">Modifier</a>
                    @endcan
                    @can('delete', $post)
                        <a href="#" class="btn btn-primary d-inline" 
                        onclick="event.preventDefault();
                                document.getElementById('delete-form').setAttribute('action', '{{ route('post.destroy', ['id' => $post->id]) }}');
                                document.getElementById('delete-form').submit();">
                            Supprimer
                        </a>
                        <form id="delete-form" action="" method="POST" class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    @endcan
                    @can('restore', $post)
                        <a href="#" class="btn btn-primary" 
                        onclick="event.preventDefault();
                                document.getElementById('restore-form').setAttribute('action', '{{ route('post.restore', ['id' => $post->id]) }}');
                                document.getElementById('restore-form').submit();">
                            Restaurer
                        </a>
                        <form id="restore-form" action="" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endcan
                @endauth
            </div>
        @empty
            <p>No posts yet !</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('post._sideNav')
    </div>
</div>
@endsection