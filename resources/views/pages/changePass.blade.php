@extends('layout.master')
@section('content')
<form action="{{route('users.UpdatePassword')}}" method="POST">
	@csrf
	@method('PUT')
	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		@error('email')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror

	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" name="password">
		@error('password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror

	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Re-type Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" name="c_password">
		@error('c_password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror
	</div>
	<button type="submit" class="btn btn-primary">Update Password</button>
</form>
@endsection
