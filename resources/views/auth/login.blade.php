@extends('layouts.auth')
@section('title') Login Page @endsection

@section('main')
<form id="formAuthentication" class="mb-3" action="{{ route('authenticate') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input
      type="text"
      class="form-control"
      id="username"
      name="username"
      placeholder="Enter your username"
      required
      @if (isset($_COOKIE["username"]))
        value="{{ $_COOKIE['username'] }}"
      @else
        value="{{ old('username') }}"        
      @endif
      autofocus />
    @error('username')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3 form-password-toggle">
    <div class="d-flex justify-content-between">
      <label class="form-label" for="password">Password</label>
    </div>
    <div class="input-group input-group-merge">
      <input
        type="password"
        id="password"
        class="form-control"
        name="password"
        @if (isset($_COOKIE["password"]))
          value="{{ $_COOKIE['password'] }}"                  
        @endif
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="password" />
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
    @error('password')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" checked id="remember-me" />
      <label class="form-check-label" for="remember-me"> Remember Me </label>
    </div>
  </div>
  <div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
  </div>
</form>
<p class="text-center">
  <span>New on our platform?</span>
  <a href="{{ route('signup') }}">
    <span>Create an account</span>
  </a>
</p>
@endsection