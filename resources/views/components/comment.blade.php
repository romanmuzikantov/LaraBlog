<div class="bg-white shadow-sm p-3 mb-3 rounded rounded-lg">
    <p>{{ $comment->content }}</p>
    <p class="text-muted mb-0">{{ $comment->created_at->locale('fr_FR')->diffForHumans() }} par {{ $comment->user->name }}</p>
</div>