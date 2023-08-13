@if ($errors->any())
<div class="my-2">
  <div class="py-2">
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif

