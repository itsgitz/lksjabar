<x-auth-layout>
  <x-slot:title>Sign in for Write the News</x-slot:title>
  <x-auth-title>Sign in for Write the News</x-auth-title>
  <x-auth-message-errors />
  <div class="row justify-content-center">
    <div class="col-md-3">
      <form action="{{ route('auth.login') }}" method="post">
        @csrf
        <div class="form-floating mb-3">
          <input id="email" class="form-control" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
          <label for="email">Email Address</label>
        </div>
        <div class="form-floating mb-3">
          <input id="password" class="form-control" type="password" name="password" placeholder="Password" value="" required>
          <label for="password">Password</label>
        </div>
        <div class="mb-3">
          <button class="btn btn-dark w-100">Login</button>
        </div>
        <div class="fw-light">
          <span>
            You don't have an account yet? <a href="{{ route('auth.register') }}">Register now</a>
            or return to <a href="{{ route('news.index') }}">the news page</a>
          </span>
        </div>
      </form>
    </div>
  </div>
</x-auth-layout>
