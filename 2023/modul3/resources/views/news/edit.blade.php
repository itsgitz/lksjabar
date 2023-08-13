<x-layout>
  <x-slot:title>Edit News - {{ $news->title }}</x-slot:title>
  <x-title>Edit News - {{ $news->title }}</x-title>
  <x-message-errors />
    <div>
      <x-status-message />
    </div>
    <div class="my-3">
      <div class="py-3">
        <div class="py-3">
          <img src="{{ $news->image_url }}" width="300">
        </div>
        <form action="{{ route('news.update', ['news' => $news->id]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-floating mb-3 col-md-4">
            <input id="title" class="form-control" type="text" name="title" placeholder="Title" value="{{ $news->title }}" required>
            <label for="title">Title</label>
          </div>
          <div class="form-floating mb-3 col-md-4">
            <textarea id="content" class="form-control" name="content" placeholder="Your news content" style="height: 300px;" required>{{ $news->content }}</textarea>
            <label for="content">Content</label>
          </div>
          <div class="mb-3 col-md-4">
            <a class="btn btn-sm btn-danger" href="{{ route('news.index') }}">Cancel</a>
            <button class="btn btn-sm btn-primary" type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
</x-layout>
