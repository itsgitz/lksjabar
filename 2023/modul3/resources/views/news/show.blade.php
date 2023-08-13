<x-layout>
  <x-slot:title>{{ $news->title }}</x-slot:title>
  <div class="py-3"></div>
  <div class="py-3">
    <div>
      <h3 class="fw-bold">{{ $news->title }}</h3>
    </div>
    <div>
      <span class="fw-light">
        {{ $news->user->name }} - {{ date_format($news->created_at, 'Y/m/d H:i:s') }} &#11088;
      </span>
    </div>
  </div>
  <div class="py-3">
    <div class="text-center py-3">
      <img class="img-fluid" src="{{ $news->image_url }}" width="400" height="400">
    </div>
    <div class="py-3">
      {{ $news->content }}
    </div>
  </div>
  <div class="py-3">
    <a class="btn btn-sm btn-secondary" href="{{ route('news.index') }}">Back</a>
    @if (Auth::check())
    <a class="btn btn-sm btn-warning" href="{{ route('news.edit', ['news' => $news->id]) }}">Edit</a>
    <a class="btn btn-sm btn-danger" href="{{ route('news.destroy', ['news' => $news->id]) }}">Remove</a>
    @endif
  </div>
</x-layout>
