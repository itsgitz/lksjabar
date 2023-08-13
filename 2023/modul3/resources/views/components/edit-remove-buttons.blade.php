@if ($isLogin)
<a class="btn btn-sm btn-warning" href="{{ route('news.edit', ['news' => $id]) }}">Edit</a>
<a class="btn btn-sm btn-danger" href="{{ route('news.destroy', ['news' => $id]) }}">Remove</a>
@endif
