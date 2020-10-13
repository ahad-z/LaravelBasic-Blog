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
<div style="margin-left: 450px;">
	<div>
		<h4 style="font-style:italic;">Sign Up with following sites </h4>
	</div>
	<br>
	<a href="{{ route('github') }}" class="btn btn-lg" style=" margin-top: -10px; box-shadow: -1px 2px 10px 0px #888888;"><i class="fa fa-github" aria-hidden="true"></i></a>
	<a href="{{ route('facebook') }}" class="btn btn-lg" style=" margin-left: 10px; margin-top: -10px;   box-shadow: -1px 2px 10px 0px #888888;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
	<a href="{{  route('google') }}" class="btn btn-lg" style=" margin-left: 10px; margin-top: -10px;   box-shadow: -1px 2px 10px 0px #888888;"><i class="fa fa-google" aria-hidden="true"></i></a>
</div>
@endsection
