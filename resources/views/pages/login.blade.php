@extends('layout.master')
@section('content')
<form action="{{route('users.login')}}" method="POST">
	@csrf
	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" name="password">
	</div>
	<button type="submit" class="btn btn-primary">Login</button>
</form>
	<a style="float: right; margin-top: -40px;"  class="btn btn-primary" href="{{route('users.passwordView')}}">Forot password</a>
@endsection
