@extends('layout.master')
@section('content')
<form action="{{route('users.sendEmail')}}" method="POST">
	@csrf
	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
	<a href="{{route('users.create')}}" style="float: right; margin-top: -40px;" class="btn btn-primary">Back to the login</a>
@endsection
