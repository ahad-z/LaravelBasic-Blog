@extends('layout.master')
@section('content')
<form class="form-group" method="post" action="{{route('users.store')}}">
	@csrf
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
		@error('name')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
		@error('email')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror

	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" id="password" name="password">
		@error('password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror

	</div>
	<div class="form-group">
		<label for="password">Re-type Your Password</label>
		<input type="password" class="form-control" id="password" name="c_password">
		@error('c_password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror

	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>
@endsection
