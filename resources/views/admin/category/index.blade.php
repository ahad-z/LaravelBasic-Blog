@extends('layout.master')
@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col"><h5>All Category</h5></div>
			<div class="col text-right">
				<a class="btn btn-primary btn-sm" href="#addcategory" data-toggle="modal">Create Category</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<table class="table">
			<thead>
				<tr>
					<th>#ID</th>
					<th>Category Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@forelse($categories as $category)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $category->category }}</td>
						<td>
							<div class="btn-group">
							   <a href="#" class="btn btn-info btn-sm" data-target="#categories_{{$category->id}}" data-toggle="modal">Edit</a>
							   <form action="{{route('categories.destroy',$category->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are u sure!')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center">
							<h1>NO SHIT HERE</h1>
						</td>
					</tr>
				@endforelse
				<tr>
					<td colspan="5" style="text-align: center;">
						{{ $categories->links() }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@foreach($categories as $category)
<div class="modal fade" id="categories_{{$category->id}}">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-group" action="{{route('categories.update',$category->id)}}" method="POST">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="category">Category Name</label>
						<input type="text" class="form-control" id="name" name="category" required="" value="{{$category->category}}">
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
@include('admin.category.category')
@endsection
