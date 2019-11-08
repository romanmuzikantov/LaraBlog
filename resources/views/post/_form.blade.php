<div class="form-group">
    <label>Title</label>
    <input class="form-control" type="text" name="title" value="{{ old('title', $post->title ?? null) }}">
</div>
<div class="form-group">
    <label>Content</label>
    <textarea class="form-control" name="content" value="{{ old('content', $post->content ?? null) }}" rows="5"></textarea>
</div>

@errors(['errors' => $errors])
@enderrors