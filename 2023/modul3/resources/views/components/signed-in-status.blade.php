@if ($isLogin)
<div class="p-3">
  <span class="fw-light">You are signed in as {{ $authUser['name'] }}</span>
</div>
@endif
