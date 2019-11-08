<div class="sticky-top">
    <div class="row pt-2">
        @card(['title' => 'Posts les plus commentés'])
            @slot('subtitle')
                Informez-vous sur les posts les plus actifs de ces derniers jours !
            @endslot
            @slot('items')
                @foreach ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="{{ route('post.show', ['id' => $post->id]) }}">{{ $post->title }}</a>
                        <p class="text-muted pt-2 mb-0">{{ $post->comments_count }} comments</p>
                    </li>
                @endforeach
            @endslot
        @endcard
    </div>
    <div class="row pt-2">
        @card(['title' => 'Utilisateurs actifs'])
            @slot('subtitle')
                Les utilisateurs les plus actifs
            @endslot
            @slot('items', collect($activeUsers)->pluck('name'))
        @endcard
    </div>
</div>