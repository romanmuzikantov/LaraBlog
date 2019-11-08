<form method="POST" action="{{ route('post.comment.store', ['post' => $post->id]) }}">
    @csrf

    <textarea class="form-control mb-2" name="content" rows="3"></textarea>

    @errors(['errors' => $errors])
    @enderrors

    <button type="submit" class="btn btn-primary btn-block mt-3">Envoyer</button>
</form>