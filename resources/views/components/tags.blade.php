<p class="">
    @foreach ($tags as $tag)
        <a href="{{ route('post.tag.index', ['tagId' => $tag->id]) }}" class="badge badge-pill badge-{{ $tag->type }} badge-lg py-2 px-3">{{ $tag->name }}</a>
    @endforeach
</p>