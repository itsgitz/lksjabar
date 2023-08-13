<x-auth-layout>
  <x-slot:title>Sign up for Become a News Writer</x-slot:title>
  <x-auth-title>Sign up for Become a News Writer</x-auth-title>
  <x-auth-message-errors />
  <div class="row justify-content-center">
    <div class="col-md-3">
      <form action="{{ route('auth.store') }}" method="post">
        @csrf
        <div class="form-floating mb-3">
          <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
          <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
          <input id="email" class="form-control" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
          <label for="email">Email Address</label>
        </div>
        <div class="form-floating mb-3">
          <input id="password" class="form-control" type="password" name="password" placeholder="Password" value="" required>
          <label for="password">Password</label>
        </div>
        <div class="form-floating mb-3">
          <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
          <label for="password_confirmation">Confirm Password</label>
        </div>
        <div class="mb-3">
          <button class="btn btn-dark w-100">Register</button>
        </div>
        <div class="fw-light">
          <span>
            Already have an account? <a href="{{ route('auth.login') }}">Sign in now</a>
            or return to <a href="{{ route('news.index') }}">the news page</a>
          </span>
        </div>
      </form>
    </div>
  </div>
</x-auth-layout>
