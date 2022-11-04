@extends('layout.body')
@section('content')
<br><br>
@if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! session('error') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
@endif
<form action="/login" method="POST">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address*</label>
      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
      @error('email')
      <span class="text-danger" >
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password*</label>
      <input type="password"  name="password" class="form-control" id="password">
      @error('password')
      <span class="text-danger" >
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <span>Or</span>
    <a href="/register" class="btn btn-warning">Register</a>
</form>
@endsection