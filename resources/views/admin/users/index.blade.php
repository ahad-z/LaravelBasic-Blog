@extends('layout.master')
@section('content')
<!-- Search Widget -->
<div class="card my-4">
	<h5 class="card-header" style="text-align: center;">Search</h5>
	<div class="card-body">
		<div class="input-group">
			<input type="text" class="form-control" id="searchuser" placeholder=" Type your keyword.......">
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col"><h5>All Users</h5></div>
			<div class="col text-right">
				<a class="btn btn-primary btn-sm" href="#modalAddUser" data-toggle="modal">Create User</a>
			</div>
		</div>
	</div>
	<div class="card-body">
       <!-- DropDown For User File DownLoad -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light" style="float: right;">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Download USer Data
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href ="{{ route('users.excel') }}?fileExtention=xlsx">XLSX</a>
							<a class="dropdown-item" href="{{ route('users.excel') }}?fileExtention=pdf">PDF</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('users.excel') }}?fileExtention=html">HTML</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!-- DropDown For User File Import to DataBase-->
		{{--<nav class="navbar navbar-expand-lg navbar-light bg-light" style="float: left;">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Imposrt User Data
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href ="{{ route('impostUser.excel') }}">XLSX</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>--}}
		<div style="margin-top: -5px;">
			<form action = "{{ route('importUser.excel') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="file" name="file">
				<button type="submit" class="btn btn-info">Import</button>
			</form>
		</div>
		@if(isset($errors) && $errors->any())
			@foreach($errors->all() as $error)
			   <h5 class="lead" style="color: red">{{ $error }}</h5>
			@endforeach
		@endif
		<table class="table">
			<thead>
				<tr>
					<th>#ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="live-search">
				@forelse($users as $user)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ ucfirst($user->type) }}</td>
						<td>
							<div class="btn-group">
							   <a href="#" class="btn btn-info btn-sm" data-target="#edituser_{{$user->id}}" data-toggle="modal">Edit</a>
							   <form action="{{route('users.destroy',$user->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are u sure!')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
							</div>
						</td>
					</tr>
			      @empty
			    	<tr>
			    		<td colspan="5">
			    			<h5 class="alert alert-danger" style="text-align: center;">There is no record</h5>
			    		</td>
			    	</tr>
			    @endforelse
				<tr>
					<td colspan="5" style="text-align: center;">
						{{ $users->links() }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!-- Add user Modal -->
<div class="modal fade" id="modalAddUser">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-group" method="POST" action="{{route('users.usersCreate')}}">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" required="">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" required="">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" required="">
					</div>
					<div class="form-group">
						<label for="category_id">User Type</label>
						<select class="form-control" name="type">
							<option value="user">User</option>
							<option value="admin">Admin</option>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	<!-- Edit modal -->
	@foreach($users as $user)
		<div class="modal fade" id="edituser_{{$user->id}}">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Update Users</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="form-group" method="POST" action="{{route('users.update',$user->id)}}">
							@csrf
							@method('PUT')
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" name="name" required="" value="{{$user->name}}">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" required="" value="{{$user->email}}">
							</div>
							<div class="form-group">
								<label for="category_id">User Type</label>
								<select class="form-control" name="type">
									<option value="user" {{$user->type == 'user'  ? 'selected'  : ''}}>User</option>
									<option value="admin" {{$user->type == 'admin' ? 'selected' : ''}}>Admin</option>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Update</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endsection
@push('scripts')
	<script>
		$(document).ready(function () {
			$('body').on('keyup', '#searchuser', function () {
				let searchContent = $(this).val();
				$.ajax({
		            url         : '{{ route("searchUsers") }}',
		            type        : "GET",
		            data        : {
		            	searchContent
		            },
		            "beforeSend" : function(){

		            },
		            "success"    : function(data){
		            	$('#live-search').html('');
						if (data) {
							$('#live-search').append(data[0]);
							$('body').append(data[1]);
						}else{
							$('#live-search').append(`
								<tr colspan = "5">
								    <td><h4 class="alert alert-danger" style="text-align: center;">No Users for "${searchContent}"!</h4></td>
								</tr>`
					          );
						}
		            },
		            "error" : function(){

		            }
		        });
			})
		})
	</script>
@endpush

