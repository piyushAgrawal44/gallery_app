@extends('layout.body')
@section('content')



<form action="/register" method="POST">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email address*</label>
      <input type="email" required class="form-control" name="email"  id="email" aria-describedby="emailHelp">
      <p id="emailHelp" class="form-text">@error('email')
        <span class="text-danger" >
            <strong>{{ $message }}</strong>
        </span>
        @enderror</p>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password*</label>
      <input type="password" required name="password" min="6" class="form-control" id="password">
      @error('password')
      <span class="text-danger" >
          <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password*</label>
        <input type="password" required name="confirm_password" class="form-control" id="confirm_password">
        @error('confirm_password')
                                    <span class="text-danger" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
      </div>
    <button type="submit" class="btn btn-primary">Register</button> <span>Or</span>
    <a href="/" class="btn btn-warning">Login</a>
</form>
    
@endsection