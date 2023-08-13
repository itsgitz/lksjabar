<x-layout>
  <x-slot:title>LKS Jabar 2023 - News</x-slot:title>
  <div>
    <x-status-message />
  </div>
  <div class="py-2"></div>
  <div class="p-1">
    @if ($news->isEmpty())
    <div class="py-3">
      <div class="alert alert-warning">
        News not found, please write yours <a href="{{ route('news.create') }}">here</a>!
      </div>
    </div>
    @else
    <div class="m-auto">
      @foreach ($news as $n)
      <div class="d-flex mb-3 rouded border-bottom px-2 py-3 gap-3">
        <div class="">
          <h4 class="fw-bold">{{ $n->title }}</h4>
          <div>
            <span class="fw-light">
              {{ $n->user->name }} - {{ date_format($n->created_at, 'Y/m/d H:i:s') }} &#11088;
            </span>
          </div>
          <div class="py-3"></div>
          <div class="py-2">
            <a class="btn btn-sm btn-success" href="{{ route('news.show', ['news' => $n->id]) }}">Read more</a>
            <x-edit-remove-buttons id="{{ $n->id }}" />
          </div>
        </div>
        <div class="ms-auto">
          <img class="img-fluid" src="{{ $n->image_url }}" width="112">
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</x-layout>
